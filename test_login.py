#!/usr/bin/env python3

import urllib.request
import urllib.parse
import http.cookiejar
import re
import sys

# Create cookie jar and opener
cookie_jar = http.cookiejar.CookieJar()
opener = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(cookie_jar))

print('[STEP 1] Fetching login page...')
try:
    response = opener.open('http://127.0.0.1:8000/login')
    page_content = response.read().decode('utf-8')
    
    # Extract CSRF token
    csrf_match = re.search(r'name="_token"\s+value="([^"]+)"', page_content)
    csrf_token = csrf_match.group(1) if csrf_match else None
    
    print(f'  Status: {response.status}')
    print(f'  Content length: {len(page_content)} bytes')
    print(f'  CSRF Token: {csrf_token[:30]}...' if csrf_token else '  CSRF Token: NOT FOUND')
    print()
except Exception as e:
    print(f'  ERROR: {e}')
    sys.exit(1)

if not csrf_token:
    print('ERROR: Could not extract CSRF token')
    sys.exit(1)

print('[STEP 2] Submitting login form...')
login_data = urllib.parse.urlencode({
    '_token': csrf_token,
    'username': 'user',
    'password': 'password123'
}).encode('utf-8')

print(f'  POST data: {len(login_data)} bytes')
print(f'  Data: {login_data.decode("utf-8")}')
print()

try:
    req = urllib.request.Request(
        'http://127.0.0.1:8000/proses_login',
        data=login_data,
        headers={'Content-Type': 'application/x-www-form-urlencoded'}
    )
    
    login_response = opener.open(req)
    print(f'  Status: {login_response.status}')
    print(f'  URL after redirect: {login_response.geturl()}')
    print()
    print('[SUCCESS] Login succeeded!')
    
except urllib.error.HTTPError as e:
    print(f'  ERROR {e.code}: {e.reason}')
    print(f'  Response headers: {dict(e.headers)}')
    
    # Try to read error response
    try:
        error_body = e.read().decode('utf-8')
        if len(error_body) < 500:
            print(f'  Error response: {error_body}')
    except:
        pass
        
except Exception as e:
    print(f'  ERROR: {e}')
    import traceback
    traceback.print_exc()
