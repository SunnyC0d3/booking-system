<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Booking System API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
                    body .content .php-example code { display: none; }
                    body .content .python-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://booking-system.com";
        var useCsrf = Boolean();
        var csrfUrl = "";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.3.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.3.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;,&quot;php&quot;,&quot;python&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                            <button type="button" class="lang-button" data-language-name="php">php</button>
                                            <button type="button" class="lang-button" data-language-name="python">python</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-welcome-to-the-booking-system-api" class="tocify-header">
                <li class="tocify-item level-1" data-unique="welcome-to-the-booking-system-api">
                    <a href="#welcome-to-the-booking-system-api">Welcome to the Booking System API</a>
                </li>
                                    <ul id="tocify-subheader-welcome-to-the-booking-system-api" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="key-features">
                                <a href="#key-features">Key Features</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="getting-started">
                                <a href="#getting-started">Getting Started</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="common-patterns">
                                <a href="#common-patterns">Common Patterns</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-resources" class="tocify-header">
                <li class="tocify-item level-1" data-unique="resources">
                    <a href="#resources">Resources</a>
                </li>
                                    <ul id="tocify-subheader-resources" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="resources-GETapi-v1-resources">
                                <a href="#resources-GETapi-v1-resources">List all resources.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="resources-GETapi-v1-resources--resource--availability">
                                <a href="#resources-GETapi-v1-resources--resource--availability">Get resource availability and bookings.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-bookings" class="tocify-header">
                <li class="tocify-item level-1" data-unique="bookings">
                    <a href="#bookings">Bookings</a>
                </li>
                                    <ul id="tocify-subheader-bookings" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="bookings-POSTapi-v1-bookings">
                                <a href="#bookings-POSTapi-v1-bookings">Create a new booking.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="bookings-GETapi-v1-bookings--booking_id-">
                                <a href="#bookings-GETapi-v1-bookings--booking_id-">Get a single booking.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="bookings-PUTapi-v1-bookings--booking_id-">
                                <a href="#bookings-PUTapi-v1-bookings--booking_id-">Update a booking.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="bookings-DELETEapi-v1-bookings--booking_id-">
                                <a href="#bookings-DELETEapi-v1-bookings--booking_id-">Cancel a booking.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: September 20, 2025 at 7:23 PM UTC</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>Complete API documentation for the Production-Ready Booking System. Manage resources, availability, and bookings with automated slot generation and intelligent conflict prevention.</p>
<aside>
    <strong>Base URL</strong>: <code>http://booking-system.com</code>
</aside>
<h1 id="welcome-to-the-booking-system-api">Welcome to the Booking System API</h1>
<p>This API provides comprehensive booking management with automated availability generation and intelligent conflict prevention.</p>
<h2 id="key-features">Key Features</h2>
<ul>
<li><strong>Resource Management</strong>: List and query bookable resources</li>
<li><strong>Flexible Availability</strong>: Query availability by date, date range, or days ahead</li>
<li><strong>Smart Booking</strong>: Automatic conflict detection and capacity management</li>
<li><strong>Holiday Support</strong>: Built-in blackout date system for holidays and maintenance</li>
<li><strong>Calendar Integration</strong>: Frontend-ready responses for calendar components</li>
</ul>
<h2 id="getting-started">Getting Started</h2>
<ol>
<li><strong>Authentication</strong>: All endpoints require a Sanctum Bearer token</li>
<li><strong>Generate Token</strong>: Use <code>php artisan api-client:create</code> to create API credentials</li>
<li><strong>Base URL</strong>: All endpoints are prefixed with <code>/api/v1</code></li>
<li><strong>Rate Limiting</strong>: 60 requests per minute per token</li>
</ol>
<h2 id="common-patterns">Common Patterns</h2>
<p>Most endpoints follow RESTful conventions with enhanced query capabilities:</p>
<ul>
<li>Single date queries: <code>?date=2025-09-18</code></li>
<li>Date range queries: <code>?from=2025-09-18&amp;to=2025-09-25</code></li>
<li>Relative queries: <code>?days=7</code> (next 7 days from today)</li>
</ul>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer Bearer {YOUR_SANCTUM_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>
<p>Generate a token using: php artisan api-client:create &quot;Your Name&quot; &quot;your.email@example.com&quot;</p>

        <h1 id="resources">Resources</h1>

    

                                <h2 id="resources-GETapi-v1-resources">List all resources.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieves all bookable resources in the system with their basic information
including name, description, capacity, and availability rules.</p>

<span id="example-requests-GETapi-v1-resources">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/resources" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"per_page\": 1,
    \"page\": 22,
    \"search\": \"gzmi\",
    \"capacity_min\": 43,
    \"capacity_max\": 16,
    \"sort_by\": \"created_at\",
    \"sort_direction\": \"asc\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/resources"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "per_page": 1,
    "page": 22,
    "search": "gzmi",
    "capacity_min": 43,
    "capacity_max": 16,
    "sort_by": "created_at",
    "sort_direction": "asc"
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/resources';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'per_page' =&gt; 1,
            'page' =&gt; 22,
            'search' =&gt; 'gzmi',
            'capacity_min' =&gt; 43,
            'capacity_max' =&gt; 16,
            'sort_by' =&gt; 'created_at',
            'sort_direction' =&gt; 'asc',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/resources'
payload = {
    "per_page": 1,
    "page": 22,
    "search": "gzmi",
    "capacity_min": 43,
    "capacity_max": 16,
    "sort_by": "created_at",
    "sort_direction": "asc"
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-resources">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Conference Room A&quot;,
            &quot;description&quot;: &quot;Large conference room for up to 12 people&quot;,
            &quot;capacity&quot;: 12,
            &quot;availability_rules&quot;: {
                &quot;monday&quot;: [
                    &quot;09:00-17:00&quot;
                ],
                &quot;tuesday&quot;: [
                    &quot;09:00-17:00&quot;
                ],
                &quot;wednesday&quot;: [
                    &quot;09:00-17:00&quot;
                ],
                &quot;thursday&quot;: [
                    &quot;09:00-17:00&quot;
                ],
                &quot;friday&quot;: [
                    &quot;09:00-17:00&quot;
                ]
            }
        },
        {
            &quot;id&quot;: 2,
            &quot;name&quot;: &quot;Meeting Room B&quot;,
            &quot;description&quot;: &quot;Small meeting room for up to 4 people&quot;,
            &quot;capacity&quot;: 4,
            &quot;availability_rules&quot;: {
                &quot;monday&quot;: [
                    &quot;08:00-20:00&quot;
                ],
                &quot;tuesday&quot;: [
                    &quot;08:00-20:00&quot;
                ],
                &quot;wednesday&quot;: [
                    &quot;08:00-20:00&quot;
                ],
                &quot;thursday&quot;: [
                    &quot;08:00-20:00&quot;
                ],
                &quot;friday&quot;: [
                    &quot;08:00-20:00&quot;
                ]
            }
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-resources" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-resources"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-resources"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-resources" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-resources">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-resources" data-method="GET"
      data-path="api/v1/resources"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-resources', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-resources"
                    onclick="tryItOut('GETapi-v1-resources');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-resources"
                    onclick="cancelTryOut('GETapi-v1-resources');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-resources"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/resources</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-resources"
               value="Bearer Bearer {YOUR_SANCTUM_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer Bearer {YOUR_SANCTUM_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-resources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-resources"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-resources"
               value="1"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-resources"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>22</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>search</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="search"                data-endpoint="GETapi-v1-resources"
               value="gzmi"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Must be at least 2 characters. Example: <code>gzmi</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>capacity_min</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="capacity_min"                data-endpoint="GETapi-v1-resources"
               value="43"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>43</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>capacity_max</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="capacity_max"                data-endpoint="GETapi-v1-resources"
               value="16"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>16</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>sort_by</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_by"                data-endpoint="GETapi-v1-resources"
               value="created_at"
               data-component="body">
    <br>
<p>Example: <code>created_at</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>name</code></li> <li><code>capacity</code></li> <li><code>created_at</code></li> <li><code>updated_at</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-v1-resources"
               value="asc"
               data-component="body">
    <br>
<p>Example: <code>asc</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>asc</code></li> <li><code>desc</code></li></ul>
        </div>
        </form>

                    <h2 id="resources-GETapi-v1-resources--resource--availability">Get resource availability and bookings.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieves availability information for a specific resource with flexible date querying.
Returns availability slots, existing bookings, and calendar-formatted data for frontend integration.</p>
<p>The endpoint supports multiple query modes:</p>
<ul>
<li>Single date: Returns availability for one specific date</li>
<li>Date range: Returns availability between two dates</li>
<li>Days ahead: Returns availability for N days starting from today</li>
<li>Default: Returns today's availability if no parameters provided</li>
</ul>

<span id="example-requests-GETapi-v1-resources--resource--availability">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/resources/architecto/availability" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"date\": \"2051-10-14\",
    \"from\": \"2021-10-14\",
    \"to\": \"2051-10-14\",
    \"days\": 22
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/resources/architecto/availability"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "date": "2051-10-14",
    "from": "2021-10-14",
    "to": "2051-10-14",
    "days": 22
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/resources/architecto/availability';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'date' =&gt; '2051-10-14',
            'from' =&gt; '2021-10-14',
            'to' =&gt; '2051-10-14',
            'days' =&gt; 22,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/resources/architecto/availability'
payload = {
    "date": "2051-10-14",
    "from": "2021-10-14",
    "to": "2051-10-14",
    "days": 22
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-resources--resource--availability">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;resource&quot;: {
    &quot;id&quot;: 1,
    &quot;name&quot;: &quot;Conference Room A&quot;,
    &quot;description&quot;: &quot;Large conference room&quot;,
    &quot;capacity&quot;: 12
  },
  &quot;date_range&quot;: {
    &quot;from&quot;: &quot;2025-09-18&quot;,
    &quot;to&quot;: &quot;2025-09-25&quot;
  },
  &quot;availability_slots&quot;: [
    {
      &quot;id&quot;: 1,
      &quot;date&quot;: &quot;2025-09-18&quot;,
      &quot;start_time&quot;: &quot;09:00:00&quot;,
      &quot;end_time&quot;: &quot;10:00:00&quot;,
      &quot;is_available&quot;: true
    },
    {
      &quot;id&quot;: 2,
      &quot;date&quot;: &quot;2025-09-18&quot;,
      &quot;start_time&quot;: &quot;10:00:00&quot;,
      &quot;end_time&quot;: &quot;11:00:00&quot;,
      &quot;is_available&quot;: false
    }
  ],
  &quot;bookings&quot;: [
    {
      &quot;id&quot;: 1,
      &quot;start_time&quot;: &quot;2025-09-18T10:00:00&quot;,
      &quot;end_time&quot;: &quot;2025-09-18T11:00:00&quot;,
      &quot;customer_info&quot;: {&quot;name&quot;: &quot;John Doe&quot;, &quot;email&quot;: &quot;john@example.com&quot;},
      &quot;status&quot;: &quot;confirmed&quot;
    }
  ],
  &quot;calendar_view&quot;: [
    {
      &quot;date&quot;: &quot;2025-09-18&quot;,
      &quot;total_slots&quot;: 8,
      &quot;available_slots&quot;: 7,
      &quot;slots&quot;: [...]
    },
    {
      &quot;date&quot;: &quot;2025-09-19&quot;,
      &quot;total_slots&quot;: 8,
      &quot;available_slots&quot;: 8,
      &quot;slots&quot;: [...]
    }
  ]
}</code>
 </pre>
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
  &quot;resource&quot;: {&quot;id&quot;: 1, &quot;name&quot;: &quot;Conference Room A&quot;},
  &quot;date&quot;: &quot;2025-09-18&quot;,
  &quot;availability_slots&quot;: [...],
  &quot;bookings&quot;: [...]
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Resource not found&quot;,
    &quot;errors&quot;: {
        &quot;id&quot;: [
            &quot;The selected resource ID is invalid.&quot;
        ]
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Invalid date format&quot;,
    &quot;errors&quot;: {
        &quot;date&quot;: [
            &quot;The date format is invalid. Use Y-m-d format.&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-resources--resource--availability" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-resources--resource--availability"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-resources--resource--availability"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-resources--resource--availability" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-resources--resource--availability">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-resources--resource--availability" data-method="GET"
      data-path="api/v1/resources/{resource}/availability"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-resources--resource--availability', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-resources--resource--availability"
                    onclick="tryItOut('GETapi-v1-resources--resource--availability');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-resources--resource--availability"
                    onclick="cancelTryOut('GETapi-v1-resources--resource--availability');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-resources--resource--availability"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/resources/{resource}/availability</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-resources--resource--availability"
               value="Bearer Bearer {YOUR_SANCTUM_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer Bearer {YOUR_SANCTUM_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resource</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="resource"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="architecto"
               data-component="url">
    <br>
<p>The resource. Example: <code>architecto</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="2051-10-14"
               data-component="body">
    <br>
<p>Must be a valid date in the format <code>Y-m-d</code>. Must be a date after or equal to <code>today</code>. Example: <code>2051-10-14</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="from"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="2021-10-14"
               data-component="body">
    <br>
<p>This field is required when <code>to</code> is present. Must be a valid date in the format <code>Y-m-d</code>. Must be a date after or equal to <code>today</code>. Must be a date before or equal to <code>to</code>. Example: <code>2021-10-14</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="to"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="2051-10-14"
               data-component="body">
    <br>
<p>This field is required when <code>from</code> is present. Must be a valid date in the format <code>Y-m-d</code>. Must be a date after or equal to <code>today</code>. Must be a date after or equal to <code>from</code>. Example: <code>2051-10-14</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>days</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="days"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="22"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 30. Example: <code>22</code></p>
        </div>
        </form>

                <h1 id="bookings">Bookings</h1>

    

                                <h2 id="bookings-POSTapi-v1-bookings">Create a new booking.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Creates a booking for a specific resource and time slot. The system automatically:</p>
<ul>
<li>Validates booking is within allowed time window (min/max advance booking)</li>
<li>Checks for availability conflicts and resource capacity</li>
<li>Verifies no blackout dates (holidays, maintenance)</li>
<li>Marks availability slots as unavailable for single-capacity resources</li>
</ul>

<span id="example-requests-POSTapi-v1-bookings">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/bookings" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"resource_id\": 1,
    \"start_time\": \"2025-09-18T10:00:00\",
    \"end_time\": \"2025-09-18T12:00:00\",
    \"customer_info\": {
        \"name\": \"John Doe\",
        \"email\": \"john@example.com\"
    }
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/bookings"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "resource_id": 1,
    "start_time": "2025-09-18T10:00:00",
    "end_time": "2025-09-18T12:00:00",
    "customer_info": {
        "name": "John Doe",
        "email": "john@example.com"
    }
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/bookings';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'resource_id' =&gt; 1,
            'start_time' =&gt; '2025-09-18T10:00:00',
            'end_time' =&gt; '2025-09-18T12:00:00',
            'customer_info' =&gt; [
                'name' =&gt; 'John Doe',
                'email' =&gt; 'john@example.com',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/bookings'
payload = {
    "resource_id": 1,
    "start_time": "2025-09-18T10:00:00",
    "end_time": "2025-09-18T12:00:00",
    "customer_info": {
        "name": "John Doe",
        "email": "john@example.com"
    }
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-bookings">
            <blockquote>
            <p>Example response (201):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;resource&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Conference Room&quot;
        },
        &quot;start_time&quot;: &quot;2025-09-18T10:00:00&quot;,
        &quot;end_time&quot;: &quot;2025-09-18T12:00:00&quot;,
        &quot;customer_info&quot;: {
            &quot;name&quot;: &quot;John Doe&quot;,
            &quot;email&quot;: &quot;john@example.com&quot;
        },
        &quot;status&quot;: &quot;pending&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Resource not found&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Validation failed&quot;,
    &quot;errors&quot;: {
        &quot;start_time&quot;: [
            &quot;Booking time is outside allowed booking window&quot;
        ],
        &quot;availability&quot;: [
            &quot;Resource is not available in this time slot&quot;
        ],
        &quot;conflict&quot;: [
            &quot;Resource is fully booked for this interval&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-POSTapi-v1-bookings" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-bookings"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-bookings"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-bookings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-bookings">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-bookings" data-method="POST"
      data-path="api/v1/bookings"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-bookings', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-bookings"
                    onclick="tryItOut('POSTapi-v1-bookings');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-bookings"
                    onclick="cancelTryOut('POSTapi-v1-bookings');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-bookings"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/bookings</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-bookings"
               value="Bearer Bearer {YOUR_SANCTUM_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer Bearer {YOUR_SANCTUM_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-bookings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="POSTapi-v1-bookings"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>resource_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resource_id"                data-endpoint="POSTapi-v1-bookings"
               value="1"
               data-component="body">
    <br>
<p>The ID of the resource to book. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>start_time</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="start_time"                data-endpoint="POSTapi-v1-bookings"
               value="2025-09-18T10:00:00"
               data-component="body">
    <br>
<p>Start time in ISO 8601 format. Example: <code>2025-09-18T10:00:00</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>end_time</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="end_time"                data-endpoint="POSTapi-v1-bookings"
               value="2025-09-18T12:00:00"
               data-component="body">
    <br>
<p>End time in ISO 8601 format. Example: <code>2025-09-18T12:00:00</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>customer_info</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
 &nbsp;
<br>
<p>Customer information object.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.name"                data-endpoint="POSTapi-v1-bookings"
               value="John Doe"
               data-component="body">
    <br>
<p>Customer name. Example: <code>John Doe</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.email"                data-endpoint="POSTapi-v1-bookings"
               value="john@example.com"
               data-component="body">
    <br>
<p>Customer email. Example: <code>john@example.com</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="bookings-GETapi-v1-bookings--booking_id-">Get a single booking.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieves detailed information about a specific booking including
resource details and current booking status.</p>

<span id="example-requests-GETapi-v1-bookings--booking_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/bookings/1" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/bookings/1"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/bookings/1';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/bookings/1'
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-bookings--booking_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;resource&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Conference Room&quot;,
            &quot;capacity&quot;: 8
        },
        &quot;start_time&quot;: &quot;2025-09-18T10:00:00&quot;,
        &quot;end_time&quot;: &quot;2025-09-18T12:00:00&quot;,
        &quot;customer_info&quot;: {
            &quot;name&quot;: &quot;John Doe&quot;,
            &quot;email&quot;: &quot;john@example.com&quot;
        },
        &quot;status&quot;: &quot;confirmed&quot;,
        &quot;created_at&quot;: &quot;2025-09-17T15:30:00&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Booking not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-bookings--booking_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-bookings--booking_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-bookings--booking_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-bookings--booking_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-bookings--booking_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-bookings--booking_id-" data-method="GET"
      data-path="api/v1/bookings/{booking_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-bookings--booking_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-bookings--booking_id-"
                    onclick="tryItOut('GETapi-v1-bookings--booking_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-bookings--booking_id-"
                    onclick="cancelTryOut('GETapi-v1-bookings--booking_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-bookings--booking_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/bookings/{booking_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-bookings--booking_id-"
               value="Bearer Bearer {YOUR_SANCTUM_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer Bearer {YOUR_SANCTUM_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-bookings--booking_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-bookings--booking_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>booking_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="booking_id"                data-endpoint="GETapi-v1-bookings--booking_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the booking. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>booking</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="booking"                data-endpoint="GETapi-v1-bookings--booking_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the booking. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="bookings-PUTapi-v1-bookings--booking_id-">Update a booking.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Updates an existing booking. When changing time slots, the system:</p>
<ul>
<li>Validates new time is within booking window</li>
<li>Checks new time slot availability and conflicts</li>
<li>Restores old availability slots and marks new ones as unavailable</li>
<li>Prevents updates to cancelled bookings</li>
</ul>

<span id="example-requests-PUTapi-v1-bookings--booking_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://booking-system.com/api/v1/bookings/1" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"start_time\": \"2025-09-18T10:30:00\",
    \"end_time\": \"2025-09-18T12:30:00\",
    \"customer_info\": {
        \"name\": \"Jane Doe\",
        \"email\": \"jane@example.com\"
    }
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/bookings/1"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "start_time": "2025-09-18T10:30:00",
    "end_time": "2025-09-18T12:30:00",
    "customer_info": {
        "name": "Jane Doe",
        "email": "jane@example.com"
    }
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/bookings/1';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'start_time' =&gt; '2025-09-18T10:30:00',
            'end_time' =&gt; '2025-09-18T12:30:00',
            'customer_info' =&gt; [
                'name' =&gt; 'Jane Doe',
                'email' =&gt; 'jane@example.com',
            ],
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/bookings/1'
payload = {
    "start_time": "2025-09-18T10:30:00",
    "end_time": "2025-09-18T12:30:00",
    "customer_info": {
        "name": "Jane Doe",
        "email": "jane@example.com"
    }
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('PUT', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-bookings--booking_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;resource&quot;: {
            &quot;id&quot;: 1,
            &quot;name&quot;: &quot;Conference Room&quot;
        },
        &quot;start_time&quot;: &quot;2025-09-18T10:30:00&quot;,
        &quot;end_time&quot;: &quot;2025-09-18T12:30:00&quot;,
        &quot;customer_info&quot;: {
            &quot;name&quot;: &quot;Jane Doe&quot;,
            &quot;email&quot;: &quot;jane@example.com&quot;
        },
        &quot;status&quot;: &quot;pending&quot;
    }
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Booking not found&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (422):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Validation failed&quot;,
    &quot;errors&quot;: {
        &quot;availability&quot;: [
            &quot;Resource is not available in this new time slot&quot;
        ],
        &quot;conflict&quot;: [
            &quot;Resource is fully booked for this interval&quot;
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-PUTapi-v1-bookings--booking_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-bookings--booking_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-bookings--booking_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-bookings--booking_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-bookings--booking_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-bookings--booking_id-" data-method="PUT"
      data-path="api/v1/bookings/{booking_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-bookings--booking_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-bookings--booking_id-"
                    onclick="tryItOut('PUTapi-v1-bookings--booking_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-bookings--booking_id-"
                    onclick="cancelTryOut('PUTapi-v1-bookings--booking_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-bookings--booking_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/bookings/{booking_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="Bearer Bearer {YOUR_SANCTUM_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer Bearer {YOUR_SANCTUM_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>booking_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="booking_id"                data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the booking. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>booking</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="booking"                data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the booking to update. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>start_time</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="start_time"                data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="2025-09-18T10:30:00"
               data-component="body">
    <br>
<p>optional New start time in ISO 8601 format. Example: <code>2025-09-18T10:30:00</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>end_time</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="end_time"                data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="2025-09-18T12:30:00"
               data-component="body">
    <br>
<p>optional New end time in ISO 8601 format. Example: <code>2025-09-18T12:30:00</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>customer_info</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
<br>
<p>optional Updated customer information.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.name"                data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="Jane Doe"
               data-component="body">
    <br>
<p>optional Updated customer name. Example: <code>Jane Doe</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.email"                data-endpoint="PUTapi-v1-bookings--booking_id-"
               value="jane@example.com"
               data-component="body">
    <br>
<p>optional Updated customer email. Example: <code>jane@example.com</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="bookings-DELETEapi-v1-bookings--booking_id-">Cancel a booking.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Cancels an existing booking and restores availability slots for future bookings.
For single-capacity resources, the cancelled time slots become available again.
Cancelled bookings cannot be reactivated.</p>

<span id="example-requests-DELETEapi-v1-bookings--booking_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://booking-system.com/api/v1/bookings/1" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/bookings/1"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/bookings/1';
$response = $client-&gt;delete(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/bookings/1'
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-bookings--booking_id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Booking cancelled successfully&quot;
}</code>
 </pre>
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Booking not found&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-DELETEapi-v1-bookings--booking_id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-bookings--booking_id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-bookings--booking_id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-bookings--booking_id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-bookings--booking_id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-bookings--booking_id-" data-method="DELETE"
      data-path="api/v1/bookings/{booking_id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-bookings--booking_id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-bookings--booking_id-"
                    onclick="tryItOut('DELETEapi-v1-bookings--booking_id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-bookings--booking_id-"
                    onclick="cancelTryOut('DELETEapi-v1-bookings--booking_id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-bookings--booking_id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/bookings/{booking_id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-bookings--booking_id-"
               value="Bearer Bearer {YOUR_SANCTUM_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer Bearer {YOUR_SANCTUM_TOKEN}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="DELETEapi-v1-bookings--booking_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="DELETEapi-v1-bookings--booking_id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>booking_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="booking_id"                data-endpoint="DELETEapi-v1-bookings--booking_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the booking. Example: <code>1</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>booking</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="booking"                data-endpoint="DELETEapi-v1-bookings--booking_id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the booking to cancel. Example: <code>1</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                                                        <button type="button" class="lang-button" data-language-name="php">php</button>
                                                        <button type="button" class="lang-button" data-language-name="python">python</button>
                            </div>
            </div>
</div>
</body>
</html>
