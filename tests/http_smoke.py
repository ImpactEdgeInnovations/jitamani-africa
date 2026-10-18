"""Local-only HTTP checks. Never sends a message to an external mail service."""
from html.parser import HTMLParser
from http.cookiejar import CookieJar
from pathlib import Path
from urllib.parse import urlparse, urlencode
from urllib.request import build_opener, HTTPCookieProcessor, Request
from urllib.error import HTTPError
import json
import re
import sys
import xml.etree.ElementTree as ET

BASE = sys.argv[1].rstrip('/') if len(sys.argv) > 1 else 'http://127.0.0.1:8088'
if urlparse(BASE).hostname not in ('127.0.0.1', 'localhost', '::1'):
    raise SystemExit('This test suite only permits localhost.')
client = build_opener(HTTPCookieProcessor(CookieJar()))
count = 0

def check(condition, message):
    global count
    assert condition, message
    count += 1
    print('PASS', message)

def request(path, data=None):
    req = Request(BASE + path, data=urlencode(data).encode() if data is not None else None)
    try:
        response = client.open(req, timeout=30)
    except HTTPError as error:
        response = error
    return response.status, response.headers, response.read()

class Page(HTMLParser):
    def __init__(self, text):
        super().__init__()
        self.h1 = 0
        self.images = []
        self.csrf = None
        self.feed(text)
    def handle_starttag(self, tag, attributes):
        a = dict(attributes)
        if tag == 'h1': self.h1 += 1
        if tag == 'img': self.images.append(a)
        if tag == 'input' and a.get('name') == 'csrf': self.csrf = a['value']

routes = ['/', '/about', '/services', '/work', '/contact', '/work/the-chef-and-the-cook', '/work/cocktail-takeover', '/blogs', '/privacy', '/blogs/exploring-the-new-basque-cuisine-through-molecular-gastronomy-at-the-chef-and-the-cook', '/blogs/global-cocktail-culture-meets-nairobi-a-sensational-pop-up-bar-takeover-by-jitamani-africa']
images = set()
for path in routes:
    status, headers, raw = request(path)
    text = raw.decode()
    parsed = Page(text)
    check(status == 200 and parsed.h1 == 1, f'{path}: 200 with one main heading')
    check('noindex' in headers.get('X-Robots-Tag', ''), f'{path}: local preview excluded from indexing')
    check('blog-details.html' not in text, f'{path}: no broken legacy template link')
    for image in parsed.images:
        check(bool(image.get('alt')), f'{path}: image has a description')
        images.add(urlparse(image['src']).path)
for image in images:
    status, headers, raw = request(image)
    check(status == 200 and headers.get_content_type().startswith('image/') and len(raw) > 100, f'Responsive photograph available: {image}')

for path in ['/site/config/config.php', '/content/site.txt', '/vendor/autoload.php', '/composer.lock', '/storage/inquiries/test.json', '/.git/config', '/tests/run.php', '/scripts/inquiries.php', '/site%2Fconfig%2Fconfig.php']:
    status, _, raw = request(path)
    check(status in (403, 404) and b'<?php' not in raw, f'Private path blocked: {path}')
status, _, raw = request('/not-a-real-page')
check(status == 404 and b'A different' in raw, 'Useful 404 response')
status, _, raw = request('/sitemap.xml')
root = ET.fromstring(raw)
check(status == 200 and len(root) == len(routes), 'Sitemap contains all public pages and archive URLs once')
status, _, raw = request('/robots.txt')
check(status == 200 and b'Disallow: /' in raw, 'Local robots disallows indexing')

status, _, raw = request('/contact')
check(b'email delivery is disabled' in raw, 'Contact form is in local-only mode before submission')
csrf = Page(raw.decode()).csrf
check(bool(csrf), 'CSRF token generated')
status, _, raw = request('/contact', {'name': 'Local Test', 'email': 'local@example.test', 'message': 'A local test inquiry.', 'csrf': 'incorrect'})
check(status == 403 and b'form has expired' in raw, 'Invalid CSRF token rejected')
status, _, raw = request('/contact', {'name': '<script>example</script>', 'email': 'bad-email', 'message': 'short', 'csrf': csrf})
check(status == 422 and b'valid email address' in raw and b'value="<script>' not in raw, 'Server validation and escaped redisplay')
status, _, raw = request('/contact', {'name': 'Local Test', 'email': 'local@example.test', 'phone': '', 'message': 'This is a synthetic inquiry from the local smoke test.', 'csrf': csrf})
check(status == 200 and b'Your test is saved.' in raw and b'No email was sent' in raw, 'Post/redirect/get confirms a locally saved inquiry without sending email')
records = sorted((Path(__file__).resolve().parents[1] / 'storage/inquiries').glob('inquiry-*.json'), key=lambda p: p.stat().st_mtime)
check(bool(records) and json.loads(records[-1].read_text())['state'] == 'local-test', 'HTTP submission has a durable local recovery copy')
status, _, raw = request('/contact')
check(b'Your test is saved.' not in raw and b'name="message"' in raw, 'Refreshing does not resubmit or repeat success')
status, _, raw = request('/panel')
check(status == 200 and b'kirby' in raw.lower(), 'Kirby Panel is available for owner setup')
print(f'\n{count} HTTP checks passed. No external inquiry or email sent.')
