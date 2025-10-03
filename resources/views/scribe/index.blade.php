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
                                                                                <li class="tocify-item level-2" data-unique="bookings-GETapi-v1-bookings--id-">
                                <a href="#bookings-GETapi-v1-bookings--id-">Get a single booking.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="bookings-PUTapi-v1-bookings--id-">
                                <a href="#bookings-PUTapi-v1-bookings--id-">Update a booking.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="bookings-DELETEapi-v1-bookings--id-">
                                <a href="#bookings-DELETEapi-v1-bookings--id-">Cancel a booking.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-calendar-authentication" class="tocify-header">
                <li class="tocify-item level-1" data-unique="calendar-authentication">
                    <a href="#calendar-authentication">Calendar Authentication</a>
                </li>
                                    <ul id="tocify-subheader-calendar-authentication" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="calendar-authentication-GETapi-v1-auth-microsoft-url">
                                <a href="#calendar-authentication-GETapi-v1-auth-microsoft-url">Get Microsoft OAuth authorization URL.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="calendar-authentication-GETapi-v1-auth-microsoft-callback">
                                <a href="#calendar-authentication-GETapi-v1-auth-microsoft-callback">Handle OAuth callback from Microsoft.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="calendar-authentication-GETapi-v1-auth-microsoft-status">
                                <a href="#calendar-authentication-GETapi-v1-auth-microsoft-status">Get current authentication status.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="calendar-authentication-POSTapi-v1-auth-microsoft-refresh">
                                <a href="#calendar-authentication-POSTapi-v1-auth-microsoft-refresh">Refresh access token.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="calendar-authentication-POSTapi-v1-auth-microsoft-disconnect">
                                <a href="#calendar-authentication-POSTapi-v1-auth-microsoft-disconnect">Disconnect calendar integration.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="calendar-authentication-GETapi-v1-auth-microsoft-test">
                                <a href="#calendar-authentication-GETapi-v1-auth-microsoft-test">Test calendar connection.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-enquiries" class="tocify-header">
                <li class="tocify-item level-1" data-unique="enquiries">
                    <a href="#enquiries">Enquiries</a>
                </li>
                                    <ul id="tocify-subheader-enquiries" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="enquiries-POSTapi-v1-enquiries">
                                <a href="#enquiries-POSTapi-v1-enquiries">Store a newly created enquiry.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiries-GETapi-v1-enquiries">
                                <a href="#enquiries-GETapi-v1-enquiries">Display a listing of enquiries.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiries-GETapi-v1-enquiries-statistics">
                                <a href="#enquiries-GETapi-v1-enquiries-statistics">Get enquiry statistics and summary.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiries-GETapi-v1-enquiries-search">
                                <a href="#enquiries-GETapi-v1-enquiries-search">Search enquiries by customer information.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiries-GETapi-v1-enquiries--id-">
                                <a href="#enquiries-GETapi-v1-enquiries--id-">Display the specified enquiry.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiries-PUTapi-v1-enquiries--id-">
                                <a href="#enquiries-PUTapi-v1-enquiries--id-">Update the specified enquiry.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiries-DELETEapi-v1-enquiries--id-">
                                <a href="#enquiries-DELETEapi-v1-enquiries--id-">Remove the specified enquiry.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-enquiry-actions" class="tocify-header">
                <li class="tocify-item level-1" data-unique="enquiry-actions">
                    <a href="#enquiry-actions">Enquiry Actions</a>
                </li>
                                    <ul id="tocify-subheader-enquiry-actions" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="enquiry-actions-POSTapi-v1-enquiries--enquiry_id--approve">
                                <a href="#enquiry-actions-POSTapi-v1-enquiries--enquiry_id--approve">Approve an enquiry.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiry-actions-POSTapi-v1-enquiries--enquiry_id--decline">
                                <a href="#enquiry-actions-POSTapi-v1-enquiries--enquiry_id--decline">Decline an enquiry.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiry-actions-POSTapi-v1-enquiries--enquiry_id--cancel">
                                <a href="#enquiry-actions-POSTapi-v1-enquiries--enquiry_id--cancel">Cancel an enquiry.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiry-actions-GETapi-v1-enquiries-actions--token--approve">
                                <a href="#enquiry-actions-GETapi-v1-enquiries-actions--token--approve">Handle action via secure token (from email links).</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="enquiry-actions-GETapi-v1-enquiries-actions--token--decline">
                                <a href="#enquiry-actions-GETapi-v1-enquiries-actions--token--decline">Handle action via secure token (from email links).</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-webhooks" class="tocify-header">
                <li class="tocify-item level-1" data-unique="webhooks">
                    <a href="#webhooks">Webhooks</a>
                </li>
                                    <ul id="tocify-subheader-webhooks" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="webhooks-POSTapi-v1-webhooks-microsoft">
                                <a href="#webhooks-POSTapi-v1-webhooks-microsoft">Handle Microsoft Calendar webhook notifications.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="webhooks-GETapi-v1-webhooks-microsoft-test">
                                <a href="#webhooks-GETapi-v1-webhooks-microsoft-test">Test webhook endpoint connectivity.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="webhooks-GETapi-v1-webhooks-microsoft-status">
                                <a href="#webhooks-GETapi-v1-webhooks-microsoft-status">Get webhook subscription status.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="webhooks-POSTapi-v1-webhooks-microsoft-subscribe">
                                <a href="#webhooks-POSTapi-v1-webhooks-microsoft-subscribe">Create or refresh webhook subscription.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="webhooks-DELETEapi-v1-webhooks-microsoft-unsubscribe">
                                <a href="#webhooks-DELETEapi-v1-webhooks-microsoft-unsubscribe">Remove webhook subscription.</a>
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
        <li>Last updated: October 3, 2025 at 3:40 PM UTC</li>
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
    \"sort_by\": \"capacity\",
    \"sort_direction\": \"desc\"
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
    "sort_by": "capacity",
    "sort_direction": "desc"
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
            'sort_by' =&gt; 'capacity',
            'sort_direction' =&gt; 'desc',
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
    "sort_by": "capacity",
    "sort_direction": "desc"
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
               value="capacity"
               data-component="body">
    <br>
<p>Example: <code>capacity</code></p>
Must be one of:
<ul style="list-style-type: square;"><li><code>name</code></li> <li><code>capacity</code></li> <li><code>created_at</code></li> <li><code>updated_at</code></li></ul>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>sort_direction</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="sort_direction"                data-endpoint="GETapi-v1-resources"
               value="desc"
               data-component="body">
    <br>
<p>Example: <code>desc</code></p>
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
    \"date\": \"2051-10-27\",
    \"from\": \"2021-10-27\",
    \"to\": \"2051-10-27\",
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
    "date": "2051-10-27",
    "from": "2021-10-27",
    "to": "2051-10-27",
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
            'date' =&gt; '2051-10-27',
            'from' =&gt; '2021-10-27',
            'to' =&gt; '2051-10-27',
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
    "date": "2051-10-27",
    "from": "2021-10-27",
    "to": "2051-10-27",
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
               value="2051-10-27"
               data-component="body">
    <br>
<p>Must be a valid date in the format <code>Y-m-d</code>. Must be a date after or equal to <code>today</code>. Example: <code>2051-10-27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="from"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="2021-10-27"
               data-component="body">
    <br>
<p>This field is required when <code>to</code> is present. Must be a valid date in the format <code>Y-m-d</code>. Must be a date after or equal to <code>today</code>. Must be a date before or equal to <code>to</code>. Example: <code>2021-10-27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="to"                data-endpoint="GETapi-v1-resources--resource--availability"
               value="2051-10-27"
               data-component="body">
    <br>
<p>This field is required when <code>from</code> is present. Must be a valid date in the format <code>Y-m-d</code>. Must be a date after or equal to <code>today</code>. Must be a date after or equal to <code>from</code>. Example: <code>2051-10-27</code></p>
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

                    <h2 id="bookings-GETapi-v1-bookings--id-">Get a single booking.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Retrieves detailed information about a specific booking including
resource details and current booking status.</p>

<span id="example-requests-GETapi-v1-bookings--id-">
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

<span id="example-responses-GETapi-v1-bookings--id-">
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
<span id="execution-results-GETapi-v1-bookings--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-bookings--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-bookings--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-bookings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-bookings--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-bookings--id-" data-method="GET"
      data-path="api/v1/bookings/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-bookings--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-bookings--id-"
                    onclick="tryItOut('GETapi-v1-bookings--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-bookings--id-"
                    onclick="cancelTryOut('GETapi-v1-bookings--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-bookings--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/bookings/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-bookings--id-"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-bookings--id-"
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
                              name="Accept"                data-endpoint="GETapi-v1-bookings--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-bookings--id-"
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
               step="any"               name="booking"                data-endpoint="GETapi-v1-bookings--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the booking. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="bookings-PUTapi-v1-bookings--id-">Update a booking.</h2>

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

<span id="example-requests-PUTapi-v1-bookings--id-">
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

<span id="example-responses-PUTapi-v1-bookings--id-">
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
<span id="execution-results-PUTapi-v1-bookings--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-bookings--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-bookings--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-bookings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-bookings--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-bookings--id-" data-method="PUT"
      data-path="api/v1/bookings/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-bookings--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-bookings--id-"
                    onclick="tryItOut('PUTapi-v1-bookings--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-bookings--id-"
                    onclick="cancelTryOut('PUTapi-v1-bookings--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-bookings--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/bookings/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-v1-bookings--id-"
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
                              name="Content-Type"                data-endpoint="PUTapi-v1-bookings--id-"
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
                              name="Accept"                data-endpoint="PUTapi-v1-bookings--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-v1-bookings--id-"
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
               step="any"               name="booking"                data-endpoint="PUTapi-v1-bookings--id-"
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
                              name="start_time"                data-endpoint="PUTapi-v1-bookings--id-"
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
                              name="end_time"                data-endpoint="PUTapi-v1-bookings--id-"
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
                              name="customer_info.name"                data-endpoint="PUTapi-v1-bookings--id-"
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
                              name="customer_info.email"                data-endpoint="PUTapi-v1-bookings--id-"
               value="jane@example.com"
               data-component="body">
    <br>
<p>optional Updated customer email. Example: <code>jane@example.com</code></p>
                    </div>
                                    </details>
        </div>
        </form>

                    <h2 id="bookings-DELETEapi-v1-bookings--id-">Cancel a booking.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Cancels an existing booking and restores availability slots for future bookings.
For single-capacity resources, the cancelled time slots become available again.
Cancelled bookings cannot be reactivated.</p>

<span id="example-requests-DELETEapi-v1-bookings--id-">
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

<span id="example-responses-DELETEapi-v1-bookings--id-">
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
<span id="execution-results-DELETEapi-v1-bookings--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-bookings--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-bookings--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-bookings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-bookings--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-bookings--id-" data-method="DELETE"
      data-path="api/v1/bookings/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-bookings--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-bookings--id-"
                    onclick="tryItOut('DELETEapi-v1-bookings--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-bookings--id-"
                    onclick="cancelTryOut('DELETEapi-v1-bookings--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-bookings--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/bookings/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-bookings--id-"
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
                              name="Content-Type"                data-endpoint="DELETEapi-v1-bookings--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-bookings--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-v1-bookings--id-"
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
               step="any"               name="booking"                data-endpoint="DELETEapi-v1-bookings--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the booking to cancel. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="calendar-authentication">Calendar Authentication</h1>

    

                                <h2 id="calendar-authentication-GETapi-v1-auth-microsoft-url">Get Microsoft OAuth authorization URL.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Generates the authorization URL that the business owner needs to visit
to grant calendar permissions to the application.</p>

<span id="example-requests-GETapi-v1-auth-microsoft-url">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/auth/microsoft/url?user_identifier=owner%40business.com&amp;redirect_uri=https%3A%2F%2Fyourapp.com%2Fauth%2Fcallback" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/auth/microsoft/url"
);

const params = {
    "user_identifier": "owner@business.com",
    "redirect_uri": "https://yourapp.com/auth/callback",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
$url = 'http://booking-system.com/api/v1/auth/microsoft/url';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'user_identifier' =&gt; 'owner@business.com',
            'redirect_uri' =&gt; 'https://yourapp.com/auth/callback',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/auth/microsoft/url'
params = {
  'user_identifier': 'owner@business.com',
  'redirect_uri': 'https://yourapp.com/auth/callback',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-auth-microsoft-url">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;auth_url&quot;: &quot;https://login.microsoftonline.com/common/oauth2/v2.0/authorize?client_id=&amp;response_type=code&amp;redirect_uri=https%3A%2F%2Fyourapp.com%2Fauth%2Fcallback&amp;scope=https%3A%2F%2Fgraph.microsoft.com%2FCalendars.ReadWrite+https%3A%2F%2Fgraph.microsoft.com%2Foffline_access&amp;state=2nO2qQ3pevntrjEVfAe7nRMUgVbDh7FS&amp;response_mode=query&amp;prompt=consent&quot;,
    &quot;state&quot;: &quot;2nO2qQ3pevntrjEVfAe7nRMUgVbDh7FS&quot;,
    &quot;expires_in&quot;: 600,
    &quot;instructions&quot;: &quot;Visit the auth_url to grant calendar permissions, then return to handle the callback.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-auth-microsoft-url" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-auth-microsoft-url"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-auth-microsoft-url"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-auth-microsoft-url" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-auth-microsoft-url">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-auth-microsoft-url" data-method="GET"
      data-path="api/v1/auth/microsoft/url"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-auth-microsoft-url', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-auth-microsoft-url"
                    onclick="tryItOut('GETapi-v1-auth-microsoft-url');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-auth-microsoft-url"
                    onclick="cancelTryOut('GETapi-v1-auth-microsoft-url');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-auth-microsoft-url"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/auth/microsoft/url</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-auth-microsoft-url"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-auth-microsoft-url"
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
                              name="Accept"                data-endpoint="GETapi-v1-auth-microsoft-url"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_identifier</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_identifier"                data-endpoint="GETapi-v1-auth-microsoft-url"
               value="owner@business.com"
               data-component="query">
    <br>
<p>User identifier (usually business owner email). Example: <code>owner@business.com</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>redirect_uri</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="redirect_uri"                data-endpoint="GETapi-v1-auth-microsoft-url"
               value="https://yourapp.com/auth/callback"
               data-component="query">
    <br>
<p>Optional custom redirect URI. Example: <code>https://yourapp.com/auth/callback</code></p>
            </div>
                </form>

                    <h2 id="calendar-authentication-GETapi-v1-auth-microsoft-callback">Handle OAuth callback from Microsoft.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint processes the OAuth callback from Microsoft and exchanges
the authorization code for access tokens.</p>

<span id="example-requests-GETapi-v1-auth-microsoft-callback">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/auth/microsoft/callback?code=M.C507_BAY.2.U.4d8d1234-5678-90ab-cdef-1234567890ab&amp;state=abc123def456&amp;error=access_denied&amp;error_description=architecto" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/auth/microsoft/callback"
);

const params = {
    "code": "M.C507_BAY.2.U.4d8d1234-5678-90ab-cdef-1234567890ab",
    "state": "abc123def456",
    "error": "access_denied",
    "error_description": "architecto",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
$url = 'http://booking-system.com/api/v1/auth/microsoft/callback';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'code' =&gt; 'M.C507_BAY.2.U.4d8d1234-5678-90ab-cdef-1234567890ab',
            'state' =&gt; 'abc123def456',
            'error' =&gt; 'access_denied',
            'error_description' =&gt; 'architecto',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/auth/microsoft/callback'
params = {
  'code': 'M.C507_BAY.2.U.4d8d1234-5678-90ab-cdef-1234567890ab',
  'state': 'abc123def456',
  'error': 'access_denied',
  'error_description': 'architecto',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-auth-microsoft-callback">
            <blockquote>
            <p>Example response (400):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Authorization denied&quot;,
    &quot;details&quot;: &quot;architecto&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-auth-microsoft-callback" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-auth-microsoft-callback"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-auth-microsoft-callback"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-auth-microsoft-callback" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-auth-microsoft-callback">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-auth-microsoft-callback" data-method="GET"
      data-path="api/v1/auth/microsoft/callback"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-auth-microsoft-callback', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-auth-microsoft-callback"
                    onclick="tryItOut('GETapi-v1-auth-microsoft-callback');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-auth-microsoft-callback"
                    onclick="cancelTryOut('GETapi-v1-auth-microsoft-callback');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-auth-microsoft-callback"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/auth/microsoft/callback</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-auth-microsoft-callback"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-auth-microsoft-callback"
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
                              name="Accept"                data-endpoint="GETapi-v1-auth-microsoft-callback"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>code</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="code"                data-endpoint="GETapi-v1-auth-microsoft-callback"
               value="M.C507_BAY.2.U.4d8d1234-5678-90ab-cdef-1234567890ab"
               data-component="query">
    <br>
<p>Authorization code from Microsoft. Example: <code>M.C507_BAY.2.U.4d8d1234-5678-90ab-cdef-1234567890ab</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>state</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="state"                data-endpoint="GETapi-v1-auth-microsoft-callback"
               value="abc123def456"
               data-component="query">
    <br>
<p>State parameter to prevent CSRF attacks. Example: <code>abc123def456</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>error</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="error"                data-endpoint="GETapi-v1-auth-microsoft-callback"
               value="access_denied"
               data-component="query">
    <br>
<p>Error code if authorization failed. Example: <code>access_denied</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>error_description</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="error_description"                data-endpoint="GETapi-v1-auth-microsoft-callback"
               value="architecto"
               data-component="query">
    <br>
<p>Error description if authorization failed. Example: <code>architecto</code></p>
            </div>
                </form>

                    <h2 id="calendar-authentication-GETapi-v1-auth-microsoft-status">Get current authentication status.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-auth-microsoft-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/auth/microsoft/status?user_identifier=owner%40business.com" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/auth/microsoft/status"
);

const params = {
    "user_identifier": "owner@business.com",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
$url = 'http://booking-system.com/api/v1/auth/microsoft/status';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'user_identifier' =&gt; 'owner@business.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/auth/microsoft/status'
params = {
  'user_identifier': 'owner@business.com',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-auth-microsoft-status">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-auth-microsoft-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-auth-microsoft-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-auth-microsoft-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-auth-microsoft-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-auth-microsoft-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-auth-microsoft-status" data-method="GET"
      data-path="api/v1/auth/microsoft/status"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-auth-microsoft-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-auth-microsoft-status"
                    onclick="tryItOut('GETapi-v1-auth-microsoft-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-auth-microsoft-status"
                    onclick="cancelTryOut('GETapi-v1-auth-microsoft-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-auth-microsoft-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/auth/microsoft/status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-auth-microsoft-status"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-auth-microsoft-status"
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
                              name="Accept"                data-endpoint="GETapi-v1-auth-microsoft-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_identifier</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_identifier"                data-endpoint="GETapi-v1-auth-microsoft-status"
               value="owner@business.com"
               data-component="query">
    <br>
<p>User identifier to check. Example: <code>owner@business.com</code></p>
            </div>
                </form>

                    <h2 id="calendar-authentication-POSTapi-v1-auth-microsoft-refresh">Refresh access token.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-auth-microsoft-refresh">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/auth/microsoft/refresh?user_identifier=owner%40business.com" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/auth/microsoft/refresh"
);

const params = {
    "user_identifier": "owner@business.com",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/auth/microsoft/refresh';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'user_identifier' =&gt; 'owner@business.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/auth/microsoft/refresh'
params = {
  'user_identifier': 'owner@business.com',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-microsoft-refresh">
</span>
<span id="execution-results-POSTapi-v1-auth-microsoft-refresh" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-microsoft-refresh"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-microsoft-refresh"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-microsoft-refresh" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-microsoft-refresh">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-microsoft-refresh" data-method="POST"
      data-path="api/v1/auth/microsoft/refresh"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-microsoft-refresh', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-microsoft-refresh"
                    onclick="tryItOut('POSTapi-v1-auth-microsoft-refresh');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-microsoft-refresh"
                    onclick="cancelTryOut('POSTapi-v1-auth-microsoft-refresh');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-microsoft-refresh"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/microsoft/refresh</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-auth-microsoft-refresh"
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
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-microsoft-refresh"
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
                              name="Accept"                data-endpoint="POSTapi-v1-auth-microsoft-refresh"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_identifier</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_identifier"                data-endpoint="POSTapi-v1-auth-microsoft-refresh"
               value="owner@business.com"
               data-component="query">
    <br>
<p>User identifier to refresh token for. Example: <code>owner@business.com</code></p>
            </div>
                </form>

                    <h2 id="calendar-authentication-POSTapi-v1-auth-microsoft-disconnect">Disconnect calendar integration.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-auth-microsoft-disconnect">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/auth/microsoft/disconnect?user_identifier=owner%40business.com" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/auth/microsoft/disconnect"
);

const params = {
    "user_identifier": "owner@business.com",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/auth/microsoft/disconnect';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'user_identifier' =&gt; 'owner@business.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/auth/microsoft/disconnect'
params = {
  'user_identifier': 'owner@business.com',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-auth-microsoft-disconnect">
</span>
<span id="execution-results-POSTapi-v1-auth-microsoft-disconnect" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-auth-microsoft-disconnect"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-auth-microsoft-disconnect"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-auth-microsoft-disconnect" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-auth-microsoft-disconnect">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-auth-microsoft-disconnect" data-method="POST"
      data-path="api/v1/auth/microsoft/disconnect"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-auth-microsoft-disconnect', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-auth-microsoft-disconnect"
                    onclick="tryItOut('POSTapi-v1-auth-microsoft-disconnect');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-auth-microsoft-disconnect"
                    onclick="cancelTryOut('POSTapi-v1-auth-microsoft-disconnect');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-auth-microsoft-disconnect"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/auth/microsoft/disconnect</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-auth-microsoft-disconnect"
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
                              name="Content-Type"                data-endpoint="POSTapi-v1-auth-microsoft-disconnect"
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
                              name="Accept"                data-endpoint="POSTapi-v1-auth-microsoft-disconnect"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_identifier</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_identifier"                data-endpoint="POSTapi-v1-auth-microsoft-disconnect"
               value="owner@business.com"
               data-component="query">
    <br>
<p>User identifier to disconnect. Example: <code>owner@business.com</code></p>
            </div>
                </form>

                    <h2 id="calendar-authentication-GETapi-v1-auth-microsoft-test">Test calendar connection.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-auth-microsoft-test">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/auth/microsoft/test?user_identifier=owner%40business.com" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/auth/microsoft/test"
);

const params = {
    "user_identifier": "owner@business.com",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
$url = 'http://booking-system.com/api/v1/auth/microsoft/test';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'user_identifier' =&gt; 'owner@business.com',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/auth/microsoft/test'
params = {
  'user_identifier': 'owner@business.com',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-auth-microsoft-test">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-auth-microsoft-test" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-auth-microsoft-test"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-auth-microsoft-test"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-auth-microsoft-test" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-auth-microsoft-test">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-auth-microsoft-test" data-method="GET"
      data-path="api/v1/auth/microsoft/test"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-auth-microsoft-test', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-auth-microsoft-test"
                    onclick="tryItOut('GETapi-v1-auth-microsoft-test');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-auth-microsoft-test"
                    onclick="cancelTryOut('GETapi-v1-auth-microsoft-test');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-auth-microsoft-test"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/auth/microsoft/test</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-auth-microsoft-test"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-auth-microsoft-test"
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
                              name="Accept"                data-endpoint="GETapi-v1-auth-microsoft-test"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>user_identifier</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="user_identifier"                data-endpoint="GETapi-v1-auth-microsoft-test"
               value="owner@business.com"
               data-component="query">
    <br>
<p>User identifier to test. Example: <code>owner@business.com</code></p>
            </div>
                </form>

                <h1 id="enquiries">Enquiries</h1>

    

                                <h2 id="enquiries-POSTapi-v1-enquiries">Store a newly created enquiry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Creates a new enquiry for a specific resource and sends notification emails.
This is the main endpoint customers use to submit enquiry requests.</p>

<span id="example-requests-POSTapi-v1-enquiries">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/enquiries" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"resource_id\": 1,
    \"preferred_date\": \"2025-09-25\",
    \"preferred_start_time\": \"10:00\",
    \"preferred_end_time\": \"12:00\",
    \"customer_info\": {
        \"name\": \"John Doe\",
        \"email\": \"john@example.com\",
        \"phone\": \"+1234567890\",
        \"company\": \"Acme Corp\"
    },
    \"message\": \"Looking for decoration services for a corporate event.\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "resource_id": 1,
    "preferred_date": "2025-09-25",
    "preferred_start_time": "10:00",
    "preferred_end_time": "12:00",
    "customer_info": {
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+1234567890",
        "company": "Acme Corp"
    },
    "message": "Looking for decoration services for a corporate event."
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/enquiries';
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
            'preferred_date' =&gt; '2025-09-25',
            'preferred_start_time' =&gt; '10:00',
            'preferred_end_time' =&gt; '12:00',
            'customer_info' =&gt; [
                'name' =&gt; 'John Doe',
                'email' =&gt; 'john@example.com',
                'phone' =&gt; '+1234567890',
                'company' =&gt; 'Acme Corp',
            ],
            'message' =&gt; 'Looking for decoration services for a corporate event.',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries'
payload = {
    "resource_id": 1,
    "preferred_date": "2025-09-25",
    "preferred_start_time": "10:00",
    "preferred_end_time": "12:00",
    "customer_info": {
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+1234567890",
        "company": "Acme Corp"
    },
    "message": "Looking for decoration services for a corporate event."
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-enquiries">
</span>
<span id="execution-results-POSTapi-v1-enquiries" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-enquiries"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-enquiries"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-enquiries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-enquiries">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-enquiries" data-method="POST"
      data-path="api/v1/enquiries"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-enquiries', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-enquiries"
                    onclick="tryItOut('POSTapi-v1-enquiries');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-enquiries"
                    onclick="cancelTryOut('POSTapi-v1-enquiries');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-enquiries"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/enquiries</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-enquiries"
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
                              name="Content-Type"                data-endpoint="POSTapi-v1-enquiries"
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
                              name="Accept"                data-endpoint="POSTapi-v1-enquiries"
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
               step="any"               name="resource_id"                data-endpoint="POSTapi-v1-enquiries"
               value="1"
               data-component="body">
    <br>
<p>The ID of the resource to enquire about. Example: <code>1</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>preferred_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="preferred_date"                data-endpoint="POSTapi-v1-enquiries"
               value="2025-09-25"
               data-component="body">
    <br>
<p>Preferred date in Y-m-d format. Example: <code>2025-09-25</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>preferred_start_time</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="preferred_start_time"                data-endpoint="POSTapi-v1-enquiries"
               value="10:00"
               data-component="body">
    <br>
<p>Preferred start time in H:i format. Example: <code>10:00</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>preferred_end_time</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="preferred_end_time"                data-endpoint="POSTapi-v1-enquiries"
               value="12:00"
               data-component="body">
    <br>
<p>Preferred end time in H:i format. Example: <code>12:00</code></p>
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
                              name="customer_info.name"                data-endpoint="POSTapi-v1-enquiries"
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
                              name="customer_info.email"                data-endpoint="POSTapi-v1-enquiries"
               value="john@example.com"
               data-component="body">
    <br>
<p>Customer email. Example: <code>john@example.com</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.phone"                data-endpoint="POSTapi-v1-enquiries"
               value="+1234567890"
               data-component="body">
    <br>
<p>Customer phone number. Example: <code>+1234567890</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>company</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.company"                data-endpoint="POSTapi-v1-enquiries"
               value="Acme Corp"
               data-component="body">
    <br>
<p>Customer company name. Example: <code>Acme Corp</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>message</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="message"                data-endpoint="POSTapi-v1-enquiries"
               value="Looking for decoration services for a corporate event."
               data-component="body">
    <br>
<p>Additional message or requirements. Example: <code>Looking for decoration services for a corporate event.</code></p>
        </div>
        </form>

                    <h2 id="enquiries-GETapi-v1-enquiries">Display a listing of enquiries.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-enquiries">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/enquiries?status=pending&amp;resource_id=1&amp;date=2025-09-25&amp;from=2025-09-20&amp;to=2025-09-30&amp;customer_email=john%40example.com&amp;per_page=15&amp;page=1" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries"
);

const params = {
    "status": "pending",
    "resource_id": "1",
    "date": "2025-09-25",
    "from": "2025-09-20",
    "to": "2025-09-30",
    "customer_email": "john@example.com",
    "per_page": "15",
    "page": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
$url = 'http://booking-system.com/api/v1/enquiries';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'status' =&gt; 'pending',
            'resource_id' =&gt; '1',
            'date' =&gt; '2025-09-25',
            'from' =&gt; '2025-09-20',
            'to' =&gt; '2025-09-30',
            'customer_email' =&gt; 'john@example.com',
            'per_page' =&gt; '15',
            'page' =&gt; '1',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries'
params = {
  'status': 'pending',
  'resource_id': '1',
  'date': '2025-09-25',
  'from': '2025-09-20',
  'to': '2025-09-30',
  'customer_email': 'john@example.com',
  'per_page': '15',
  'page': '1',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-enquiries">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-enquiries" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-enquiries"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-enquiries"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-enquiries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-enquiries">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-enquiries" data-method="GET"
      data-path="api/v1/enquiries"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-enquiries', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-enquiries"
                    onclick="tryItOut('GETapi-v1-enquiries');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-enquiries"
                    onclick="cancelTryOut('GETapi-v1-enquiries');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-enquiries"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/enquiries</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-enquiries"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-enquiries"
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
                              name="Accept"                data-endpoint="GETapi-v1-enquiries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="GETapi-v1-enquiries"
               value="pending"
               data-component="query">
    <br>
<p>Filter by enquiry status (pending, approved, declined, cancelled). Example: <code>pending</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>resource_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="resource_id"                data-endpoint="GETapi-v1-enquiries"
               value="1"
               data-component="query">
    <br>
<p>Filter by resource ID. Example: <code>1</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="date"                data-endpoint="GETapi-v1-enquiries"
               value="2025-09-25"
               data-component="query">
    <br>
<p>Filter by preferred date (Y-m-d format). Example: <code>2025-09-25</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="from"                data-endpoint="GETapi-v1-enquiries"
               value="2025-09-20"
               data-component="query">
    <br>
<p>Filter from date (Y-m-d format). Example: <code>2025-09-20</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="to"                data-endpoint="GETapi-v1-enquiries"
               value="2025-09-30"
               data-component="query">
    <br>
<p>Filter to date (Y-m-d format). Example: <code>2025-09-30</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>customer_email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_email"                data-endpoint="GETapi-v1-enquiries"
               value="john@example.com"
               data-component="query">
    <br>
<p>Filter by customer email. Example: <code>john@example.com</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-enquiries"
               value="15"
               data-component="query">
    <br>
<p>Number of items per page (max 100). Example: <code>15</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-enquiries"
               value="1"
               data-component="query">
    <br>
<p>Page number. Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="enquiries-GETapi-v1-enquiries-statistics">Get enquiry statistics and summary.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-enquiries-statistics">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/enquiries/statistics?from=2025-09-01&amp;to=2025-09-30" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/statistics"
);

const params = {
    "from": "2025-09-01",
    "to": "2025-09-30",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
$url = 'http://booking-system.com/api/v1/enquiries/statistics';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'from' =&gt; '2025-09-01',
            'to' =&gt; '2025-09-30',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries/statistics'
params = {
  'from': '2025-09-01',
  'to': '2025-09-30',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-enquiries-statistics">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-enquiries-statistics" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-enquiries-statistics"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-enquiries-statistics"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-enquiries-statistics" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-enquiries-statistics">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-enquiries-statistics" data-method="GET"
      data-path="api/v1/enquiries/statistics"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-enquiries-statistics', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-enquiries-statistics"
                    onclick="tryItOut('GETapi-v1-enquiries-statistics');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-enquiries-statistics"
                    onclick="cancelTryOut('GETapi-v1-enquiries-statistics');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-enquiries-statistics"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/enquiries/statistics</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-enquiries-statistics"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-enquiries-statistics"
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
                              name="Accept"                data-endpoint="GETapi-v1-enquiries-statistics"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>from</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="from"                data-endpoint="GETapi-v1-enquiries-statistics"
               value="2025-09-01"
               data-component="query">
    <br>
<p>Start date for statistics (Y-m-d format). Example: <code>2025-09-01</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>to</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="to"                data-endpoint="GETapi-v1-enquiries-statistics"
               value="2025-09-30"
               data-component="query">
    <br>
<p>End date for statistics (Y-m-d format). Example: <code>2025-09-30</code></p>
            </div>
                </form>

                    <h2 id="enquiries-GETapi-v1-enquiries-search">Search enquiries by customer information.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-enquiries-search">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/enquiries/search?q=john&amp;per_page=15" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"q\": \"bngz\",
    \"page\": 27,
    \"per_page\": 15
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/search"
);

const params = {
    "q": "john",
    "per_page": "15",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "q": "bngz",
    "page": 27,
    "per_page": 15
};

fetch(url, {
    method: "GET",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/enquiries/search';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'q' =&gt; 'john',
            'per_page' =&gt; '15',
        ],
        'json' =&gt; [
            'q' =&gt; 'bngz',
            'page' =&gt; 27,
            'per_page' =&gt; 15,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries/search'
payload = {
    "q": "bngz",
    "page": 27,
    "per_page": 15
}
params = {
  'q': 'john',
  'per_page': '15',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, json=payload, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-enquiries-search">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-enquiries-search" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-enquiries-search"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-enquiries-search"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-enquiries-search" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-enquiries-search">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-enquiries-search" data-method="GET"
      data-path="api/v1/enquiries/search"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-enquiries-search', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-enquiries-search"
                    onclick="tryItOut('GETapi-v1-enquiries-search');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-enquiries-search"
                    onclick="cancelTryOut('GETapi-v1-enquiries-search');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-enquiries-search"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/enquiries/search</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-enquiries-search"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-enquiries-search"
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
                              name="Accept"                data-endpoint="GETapi-v1-enquiries-search"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>q</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="q"                data-endpoint="GETapi-v1-enquiries-search"
               value="john"
               data-component="query">
    <br>
<p>Search term (searches name, email, company). Example: <code>john</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-enquiries-search"
               value="15"
               data-component="query">
    <br>
<p>Number of items per page (max 100). Example: <code>15</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>q</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="q"                data-endpoint="GETapi-v1-enquiries-search"
               value="bngz"
               data-component="body">
    <br>
<p>Must be at least 2 characters. Example: <code>bngz</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-enquiries-search"
               value="27"
               data-component="body">
    <br>
<p>Must be at least 1. Example: <code>27</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-enquiries-search"
               value="15"
               data-component="body">
    <br>
<p>Must be at least 1. Must not be greater than 100. Example: <code>15</code></p>
        </div>
        </form>

                    <h2 id="enquiries-GETapi-v1-enquiries--id-">Display the specified enquiry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-enquiries--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/enquiries/16" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/16"
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
$url = 'http://booking-system.com/api/v1/enquiries/16';
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

url = 'http://booking-system.com/api/v1/enquiries/16'
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-enquiries--id-">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-enquiries--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-enquiries--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-enquiries--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-enquiries--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-enquiries--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-enquiries--id-" data-method="GET"
      data-path="api/v1/enquiries/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-enquiries--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-enquiries--id-"
                    onclick="tryItOut('GETapi-v1-enquiries--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-enquiries--id-"
                    onclick="cancelTryOut('GETapi-v1-enquiries--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-enquiries--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/enquiries/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-enquiries--id-"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-enquiries--id-"
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
                              name="Accept"                data-endpoint="GETapi-v1-enquiries--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-enquiries--id-"
               value="16"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry"                data-endpoint="GETapi-v1-enquiries--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>1</code></p>
            </div>
                    </form>

                    <h2 id="enquiries-PUTapi-v1-enquiries--id-">Update the specified enquiry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PUTapi-v1-enquiries--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://booking-system.com/api/v1/enquiries/16" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"preferred_date\": \"2025-09-26\",
    \"preferred_start_time\": \"14:00\",
    \"preferred_end_time\": \"16:00\",
    \"customer_info\": {
        \"name\": \"John Doe\",
        \"email\": \"john@example.com\",
        \"phone\": \"+1234567890\",
        \"company\": \"Acme Corp\"
    },
    \"message\": \"architecto\",
    \"status\": \"approved\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/16"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "preferred_date": "2025-09-26",
    "preferred_start_time": "14:00",
    "preferred_end_time": "16:00",
    "customer_info": {
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+1234567890",
        "company": "Acme Corp"
    },
    "message": "architecto",
    "status": "approved"
};

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/enquiries/16';
$response = $client-&gt;put(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'preferred_date' =&gt; '2025-09-26',
            'preferred_start_time' =&gt; '14:00',
            'preferred_end_time' =&gt; '16:00',
            'customer_info' =&gt; [
                'name' =&gt; 'John Doe',
                'email' =&gt; 'john@example.com',
                'phone' =&gt; '+1234567890',
                'company' =&gt; 'Acme Corp',
            ],
            'message' =&gt; 'architecto',
            'status' =&gt; 'approved',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries/16'
payload = {
    "preferred_date": "2025-09-26",
    "preferred_start_time": "14:00",
    "preferred_end_time": "16:00",
    "customer_info": {
        "name": "John Doe",
        "email": "john@example.com",
        "phone": "+1234567890",
        "company": "Acme Corp"
    },
    "message": "architecto",
    "status": "approved"
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('PUT', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-enquiries--id-">
</span>
<span id="execution-results-PUTapi-v1-enquiries--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-PUTapi-v1-enquiries--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-v1-enquiries--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-PUTapi-v1-enquiries--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-v1-enquiries--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-PUTapi-v1-enquiries--id-" data-method="PUT"
      data-path="api/v1/enquiries/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('PUTapi-v1-enquiries--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-PUTapi-v1-enquiries--id-"
                    onclick="tryItOut('PUTapi-v1-enquiries--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-PUTapi-v1-enquiries--id-"
                    onclick="cancelTryOut('PUTapi-v1-enquiries--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-PUTapi-v1-enquiries--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-darkblue">PUT</small>
            <b><code>api/v1/enquiries/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="PUTapi-v1-enquiries--id-"
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
                              name="Content-Type"                data-endpoint="PUTapi-v1-enquiries--id-"
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
                              name="Accept"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="16"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>preferred_date</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="preferred_date"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="2025-09-26"
               data-component="body">
    <br>
<p>Preferred date in Y-m-d format. Example: <code>2025-09-26</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>preferred_start_time</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="preferred_start_time"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="14:00"
               data-component="body">
    <br>
<p>Preferred start time in H:i format. Example: <code>14:00</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>preferred_end_time</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="preferred_end_time"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="16:00"
               data-component="body">
    <br>
<p>Preferred end time in H:i format. Example: <code>16:00</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
        <details>
            <summary style="padding-bottom: 10px;">
                <b style="line-height: 2;"><code>customer_info</code></b>&nbsp;&nbsp;
<small>object</small>&nbsp;
<i>optional</i> &nbsp;
<br>
<p>Customer information object.</p>
            </summary>
                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>name</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.name"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="John Doe"
               data-component="body">
    <br>
<p>Customer name. Example: <code>John Doe</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>email</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.email"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="john@example.com"
               data-component="body">
    <br>
<p>Customer email. Example: <code>john@example.com</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>phone</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.phone"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="+1234567890"
               data-component="body">
    <br>
<p>Customer phone number. Example: <code>+1234567890</code></p>
                    </div>
                                                                <div style="margin-left: 14px; clear: unset;">
                        <b style="line-height: 2;"><code>company</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="customer_info.company"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="Acme Corp"
               data-component="body">
    <br>
<p>Customer company name. Example: <code>Acme Corp</code></p>
                    </div>
                                    </details>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>message</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="message"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="architecto"
               data-component="body">
    <br>
<p>Additional message or requirements. Example: <code>architecto</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>status</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="status"                data-endpoint="PUTapi-v1-enquiries--id-"
               value="approved"
               data-component="body">
    <br>
<p>Update enquiry status (pending, approved, declined, cancelled). Example: <code>approved</code></p>
        </div>
        </form>

                    <h2 id="enquiries-DELETEapi-v1-enquiries--id-">Remove the specified enquiry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-v1-enquiries--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://booking-system.com/api/v1/enquiries/16" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/16"
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
$url = 'http://booking-system.com/api/v1/enquiries/16';
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

url = 'http://booking-system.com/api/v1/enquiries/16'
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-enquiries--id-">
</span>
<span id="execution-results-DELETEapi-v1-enquiries--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-enquiries--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-enquiries--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-enquiries--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-enquiries--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-enquiries--id-" data-method="DELETE"
      data-path="api/v1/enquiries/{id}"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-enquiries--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-enquiries--id-"
                    onclick="tryItOut('DELETEapi-v1-enquiries--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-enquiries--id-"
                    onclick="cancelTryOut('DELETEapi-v1-enquiries--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-enquiries--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/enquiries/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-enquiries--id-"
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
                              name="Content-Type"                data-endpoint="DELETEapi-v1-enquiries--id-"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-enquiries--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="DELETEapi-v1-enquiries--id-"
               value="16"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry"                data-endpoint="DELETEapi-v1-enquiries--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="enquiry-actions">Enquiry Actions</h1>

    

                                <h2 id="enquiry-actions-POSTapi-v1-enquiries--enquiry_id--approve">Approve an enquiry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Approves an enquiry and optionally creates a calendar event.
Can be called via API or through secure email action links.</p>

<span id="example-requests-POSTapi-v1-enquiries--enquiry_id--approve">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/enquiries/16/approve" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"action_token\": \"abc123def456\",
    \"create_calendar_event\": true,
    \"calendar_notes\": \"Confirmed booking for corporate event\",
    \"decline_reason\": \"g\",
    \"custom_message\": \"z\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/16/approve"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "action_token": "abc123def456",
    "create_calendar_event": true,
    "calendar_notes": "Confirmed booking for corporate event",
    "decline_reason": "g",
    "custom_message": "z"
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/enquiries/16/approve';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'action_token' =&gt; 'abc123def456',
            'create_calendar_event' =&gt; true,
            'calendar_notes' =&gt; 'Confirmed booking for corporate event',
            'decline_reason' =&gt; 'g',
            'custom_message' =&gt; 'z',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries/16/approve'
payload = {
    "action_token": "abc123def456",
    "create_calendar_event": true,
    "calendar_notes": "Confirmed booking for corporate event",
    "decline_reason": "g",
    "custom_message": "z"
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-enquiries--enquiry_id--approve">
</span>
<span id="execution-results-POSTapi-v1-enquiries--enquiry_id--approve" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-enquiries--enquiry_id--approve"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-enquiries--enquiry_id--approve"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-enquiries--enquiry_id--approve" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-enquiries--enquiry_id--approve">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-enquiries--enquiry_id--approve" data-method="POST"
      data-path="api/v1/enquiries/{enquiry_id}/approve"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-enquiries--enquiry_id--approve', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-enquiries--enquiry_id--approve"
                    onclick="tryItOut('POSTapi-v1-enquiries--enquiry_id--approve');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-enquiries--enquiry_id--approve"
                    onclick="cancelTryOut('POSTapi-v1-enquiries--enquiry_id--approve');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-enquiries--enquiry_id--approve"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/enquiries/{enquiry_id}/approve</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
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
                              name="Content-Type"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
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
                              name="Accept"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry_id"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
               value="16"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
               value="1"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>action_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="action_token"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
               value="abc123def456"
               data-component="body">
    <br>
<p>Required when using email action links. Example: <code>abc123def456</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>create_calendar_event</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve" style="display: none">
            <input type="radio" name="create_calendar_event"
                   value="true"
                   data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve" style="display: none">
            <input type="radio" name="create_calendar_event"
                   value="false"
                   data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether to create a calendar event. Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>calendar_notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="calendar_notes"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
               value="Confirmed booking for corporate event"
               data-component="body">
    <br>
<p>Additional notes for the calendar event. Example: <code>Confirmed booking for corporate event</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>decline_reason</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="decline_reason"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
               value="g"
               data-component="body">
    <br>
<p>Must not be greater than 255 characters. Example: <code>g</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>custom_message</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="custom_message"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--approve"
               value="z"
               data-component="body">
    <br>
<p>Must not be greater than 1000 characters. Example: <code>z</code></p>
        </div>
        </form>

                    <h2 id="enquiry-actions-POSTapi-v1-enquiries--enquiry_id--decline">Decline an enquiry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Declines an enquiry and sends notification to the customer.
Can be called via API or through secure email action links.</p>

<span id="example-requests-POSTapi-v1-enquiries--enquiry_id--decline">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/enquiries/16/decline" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"action_token\": \"abc123def456\",
    \"create_calendar_event\": true,
    \"calendar_notes\": \"n\",
    \"decline_reason\": \"Resource not available on requested date\",
    \"custom_message\": \"Thank you for your interest. Unfortunately, we are fully booked on your preferred date.\"
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/16/decline"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "action_token": "abc123def456",
    "create_calendar_event": true,
    "calendar_notes": "n",
    "decline_reason": "Resource not available on requested date",
    "custom_message": "Thank you for your interest. Unfortunately, we are fully booked on your preferred date."
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/enquiries/16/decline';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'action_token' =&gt; 'abc123def456',
            'create_calendar_event' =&gt; true,
            'calendar_notes' =&gt; 'n',
            'decline_reason' =&gt; 'Resource not available on requested date',
            'custom_message' =&gt; 'Thank you for your interest. Unfortunately, we are fully booked on your preferred date.',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries/16/decline'
payload = {
    "action_token": "abc123def456",
    "create_calendar_event": true,
    "calendar_notes": "n",
    "decline_reason": "Resource not available on requested date",
    "custom_message": "Thank you for your interest. Unfortunately, we are fully booked on your preferred date."
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-enquiries--enquiry_id--decline">
</span>
<span id="execution-results-POSTapi-v1-enquiries--enquiry_id--decline" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-enquiries--enquiry_id--decline"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-enquiries--enquiry_id--decline"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-enquiries--enquiry_id--decline" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-enquiries--enquiry_id--decline">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-enquiries--enquiry_id--decline" data-method="POST"
      data-path="api/v1/enquiries/{enquiry_id}/decline"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-enquiries--enquiry_id--decline', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-enquiries--enquiry_id--decline"
                    onclick="tryItOut('POSTapi-v1-enquiries--enquiry_id--decline');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-enquiries--enquiry_id--decline"
                    onclick="cancelTryOut('POSTapi-v1-enquiries--enquiry_id--decline');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-enquiries--enquiry_id--decline"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/enquiries/{enquiry_id}/decline</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
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
                              name="Content-Type"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
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
                              name="Accept"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry_id"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
               value="16"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
               value="1"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>action_token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="action_token"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
               value="abc123def456"
               data-component="body">
    <br>
<p>Required when using email action links. Example: <code>abc123def456</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>create_calendar_event</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline" style="display: none">
            <input type="radio" name="create_calendar_event"
                   value="true"
                   data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline" style="display: none">
            <input type="radio" name="create_calendar_event"
                   value="false"
                   data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Example: <code>true</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>calendar_notes</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="calendar_notes"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
               value="n"
               data-component="body">
    <br>
<p>Must not be greater than 500 characters. Example: <code>n</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>decline_reason</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="decline_reason"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
               value="Resource not available on requested date"
               data-component="body">
    <br>
<p>Reason for declining the enquiry. Example: <code>Resource not available on requested date</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>custom_message</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="custom_message"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--decline"
               value="Thank you for your interest. Unfortunately, we are fully booked on your preferred date."
               data-component="body">
    <br>
<p>Custom message to include in decline email. Example: <code>Thank you for your interest. Unfortunately, we are fully booked on your preferred date.</code></p>
        </div>
        </form>

                    <h2 id="enquiry-actions-POSTapi-v1-enquiries--enquiry_id--cancel">Cancel an enquiry.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>Cancels an enquiry and removes any associated calendar events.</p>

<span id="example-requests-POSTapi-v1-enquiries--enquiry_id--cancel">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/enquiries/16/cancel" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json" \
    --data "{
    \"cancellation_reason\": \"Customer requested cancellation\",
    \"notify_customer\": true
}"
</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/16/cancel"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "cancellation_reason": "Customer requested cancellation",
    "notify_customer": true
};

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/enquiries/16/cancel';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'json' =&gt; [
            'cancellation_reason' =&gt; 'Customer requested cancellation',
            'notify_customer' =&gt; true,
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries/16/cancel'
payload = {
    "cancellation_reason": "Customer requested cancellation",
    "notify_customer": true
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers, json=payload)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-enquiries--enquiry_id--cancel">
</span>
<span id="execution-results-POSTapi-v1-enquiries--enquiry_id--cancel" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-enquiries--enquiry_id--cancel"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-enquiries--enquiry_id--cancel"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-enquiries--enquiry_id--cancel" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-enquiries--enquiry_id--cancel">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-enquiries--enquiry_id--cancel" data-method="POST"
      data-path="api/v1/enquiries/{enquiry_id}/cancel"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-enquiries--enquiry_id--cancel', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-enquiries--enquiry_id--cancel"
                    onclick="tryItOut('POSTapi-v1-enquiries--enquiry_id--cancel');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-enquiries--enquiry_id--cancel"
                    onclick="cancelTryOut('POSTapi-v1-enquiries--enquiry_id--cancel');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-enquiries--enquiry_id--cancel"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/enquiries/{enquiry_id}/cancel</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel"
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
                              name="Content-Type"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel"
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
                              name="Accept"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry_id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry_id"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel"
               value="16"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>16</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>enquiry</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="enquiry"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel"
               value="1"
               data-component="url">
    <br>
<p>The ID of the enquiry. Example: <code>1</code></p>
            </div>
                            <h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
        <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>cancellation_reason</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="cancellation_reason"                data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel"
               value="Customer requested cancellation"
               data-component="body">
    <br>
<p>Reason for cancellation. Example: <code>Customer requested cancellation</code></p>
        </div>
                <div style=" padding-left: 28px;  clear: unset;">
            <b style="line-height: 2;"><code>notify_customer</code></b>&nbsp;&nbsp;
<small>boolean</small>&nbsp;
<i>optional</i> &nbsp;
                <label data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel" style="display: none">
            <input type="radio" name="notify_customer"
                   value="true"
                   data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel"
                   data-component="body"             >
            <code>true</code>
        </label>
        <label data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel" style="display: none">
            <input type="radio" name="notify_customer"
                   value="false"
                   data-endpoint="POSTapi-v1-enquiries--enquiry_id--cancel"
                   data-component="body"             >
            <code>false</code>
        </label>
    <br>
<p>Whether to notify the customer. Example: <code>true</code></p>
        </div>
        </form>

                    <h2 id="enquiry-actions-GETapi-v1-enquiries-actions--token--approve">Handle action via secure token (from email links).</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint handles enquiry actions when accessed through email action links.
It validates the secure token and performs the requested action.</p>

<span id="example-requests-GETapi-v1-enquiries-actions--token--approve">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/enquiries/actions/abc123def456ghi789/approve?decline_reason=Not+available&amp;custom_message=Thank+you+for+your+enquiry" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/actions/abc123def456ghi789/approve"
);

const params = {
    "decline_reason": "Not available",
    "custom_message": "Thank you for your enquiry",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
$url = 'http://booking-system.com/api/v1/enquiries/actions/abc123def456ghi789/approve';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'decline_reason' =&gt; 'Not available',
            'custom_message' =&gt; 'Thank you for your enquiry',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries/actions/abc123def456ghi789/approve'
params = {
  'decline_reason': 'Not available',
  'custom_message': 'Thank you for your enquiry',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-enquiries-actions--token--approve">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Invalid or expired action token&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-enquiries-actions--token--approve" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-enquiries-actions--token--approve"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-enquiries-actions--token--approve"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-enquiries-actions--token--approve" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-enquiries-actions--token--approve">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-enquiries-actions--token--approve" data-method="GET"
      data-path="api/v1/enquiries/actions/{token}/approve"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-enquiries-actions--token--approve', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-enquiries-actions--token--approve"
                    onclick="tryItOut('GETapi-v1-enquiries-actions--token--approve');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-enquiries-actions--token--approve"
                    onclick="cancelTryOut('GETapi-v1-enquiries-actions--token--approve');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-enquiries-actions--token--approve"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/enquiries/actions/{token}/approve</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-enquiries-actions--token--approve"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-enquiries-actions--token--approve"
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
                              name="Accept"                data-endpoint="GETapi-v1-enquiries-actions--token--approve"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="token"                data-endpoint="GETapi-v1-enquiries-actions--token--approve"
               value="abc123def456ghi789"
               data-component="url">
    <br>
<p>The secure action token. Example: <code>abc123def456ghi789</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>action</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="action"                data-endpoint="GETapi-v1-enquiries-actions--token--approve"
               value="approve"
               data-component="url">
    <br>
<p>The action to perform (approve, decline). Example: <code>approve</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>decline_reason</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="decline_reason"                data-endpoint="GETapi-v1-enquiries-actions--token--approve"
               value="Not available"
               data-component="query">
    <br>
<p>Reason for declining (only for decline action). Example: <code>Not available</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>custom_message</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="custom_message"                data-endpoint="GETapi-v1-enquiries-actions--token--approve"
               value="Thank you for your enquiry"
               data-component="query">
    <br>
<p>Custom message for customer. Example: <code>Thank you for your enquiry</code></p>
            </div>
                </form>

                    <h2 id="enquiry-actions-GETapi-v1-enquiries-actions--token--decline">Handle action via secure token (from email links).</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint handles enquiry actions when accessed through email action links.
It validates the secure token and performs the requested action.</p>

<span id="example-requests-GETapi-v1-enquiries-actions--token--decline">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/enquiries/actions/abc123def456ghi789/decline?decline_reason=Not+available&amp;custom_message=Thank+you+for+your+enquiry" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/enquiries/actions/abc123def456ghi789/decline"
);

const params = {
    "decline_reason": "Not available",
    "custom_message": "Thank you for your enquiry",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

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
$url = 'http://booking-system.com/api/v1/enquiries/actions/abc123def456ghi789/decline';
$response = $client-&gt;get(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
            'Content-Type' =&gt; 'application/json',
            'Accept' =&gt; 'application/json',
        ],
        'query' =&gt; [
            'decline_reason' =&gt; 'Not available',
            'custom_message' =&gt; 'Thank you for your enquiry',
        ],
    ]
);
$body = $response-&gt;getBody();
print_r(json_decode((string) $body));</code></pre></div>


<div class="python-example">
    <pre><code class="language-python">import requests
import json

url = 'http://booking-system.com/api/v1/enquiries/actions/abc123def456ghi789/decline'
params = {
  'decline_reason': 'Not available',
  'custom_message': 'Thank you for your enquiry',
}
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers, params=params)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-enquiries-actions--token--decline">
            <blockquote>
            <p>Example response (404):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;error&quot;: &quot;Invalid or expired action token&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-enquiries-actions--token--decline" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-enquiries-actions--token--decline"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-enquiries-actions--token--decline"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-enquiries-actions--token--decline" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-enquiries-actions--token--decline">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-enquiries-actions--token--decline" data-method="GET"
      data-path="api/v1/enquiries/actions/{token}/decline"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-enquiries-actions--token--decline', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-enquiries-actions--token--decline"
                    onclick="tryItOut('GETapi-v1-enquiries-actions--token--decline');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-enquiries-actions--token--decline"
                    onclick="cancelTryOut('GETapi-v1-enquiries-actions--token--decline');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-enquiries-actions--token--decline"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/enquiries/actions/{token}/decline</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-enquiries-actions--token--decline"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-enquiries-actions--token--decline"
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
                              name="Accept"                data-endpoint="GETapi-v1-enquiries-actions--token--decline"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>token</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="token"                data-endpoint="GETapi-v1-enquiries-actions--token--decline"
               value="abc123def456ghi789"
               data-component="url">
    <br>
<p>The secure action token. Example: <code>abc123def456ghi789</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>action</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="action"                data-endpoint="GETapi-v1-enquiries-actions--token--decline"
               value="approve"
               data-component="url">
    <br>
<p>The action to perform (approve, decline). Example: <code>approve</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>decline_reason</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="decline_reason"                data-endpoint="GETapi-v1-enquiries-actions--token--decline"
               value="Not available"
               data-component="query">
    <br>
<p>Reason for declining (only for decline action). Example: <code>Not available</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>custom_message</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
                <input type="text" style="display: none"
                              name="custom_message"                data-endpoint="GETapi-v1-enquiries-actions--token--decline"
               value="Thank you for your enquiry"
               data-component="query">
    <br>
<p>Custom message for customer. Example: <code>Thank you for your enquiry</code></p>
            </div>
                </form>

                <h1 id="webhooks">Webhooks</h1>

    

                                <h2 id="webhooks-POSTapi-v1-webhooks-microsoft">Handle Microsoft Calendar webhook notifications.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>

<p>This endpoint receives webhook notifications from Microsoft Graph API
when calendar events are created, updated, or deleted.</p>

<span id="example-requests-POSTapi-v1-webhooks-microsoft">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/webhooks/microsoft" \
    --header "Authorization: Bearer {webhook_secret}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/webhooks/microsoft"
);

const headers = {
    "Authorization": "Bearer {webhook_secret}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/webhooks/microsoft';
$response = $client-&gt;post(
    $url,
    [
        'headers' =&gt; [
            'Authorization' =&gt; 'Bearer {webhook_secret}',
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

url = 'http://booking-system.com/api/v1/webhooks/microsoft'
headers = {
  'Authorization': 'Bearer {webhook_secret}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-webhooks-microsoft">
</span>
<span id="execution-results-POSTapi-v1-webhooks-microsoft" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-webhooks-microsoft"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-webhooks-microsoft"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-webhooks-microsoft" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-webhooks-microsoft">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-webhooks-microsoft" data-method="POST"
      data-path="api/v1/webhooks/microsoft"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-webhooks-microsoft', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-webhooks-microsoft"
                    onclick="tryItOut('POSTapi-v1-webhooks-microsoft');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-webhooks-microsoft"
                    onclick="cancelTryOut('POSTapi-v1-webhooks-microsoft');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-webhooks-microsoft"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/webhooks/microsoft</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-webhooks-microsoft"
               value="Bearer {webhook_secret}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {webhook_secret}</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="POSTapi-v1-webhooks-microsoft"
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
                              name="Accept"                data-endpoint="POSTapi-v1-webhooks-microsoft"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="webhooks-GETapi-v1-webhooks-microsoft-test">Test webhook endpoint connectivity.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-webhooks-microsoft-test">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/webhooks/microsoft/test" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/webhooks/microsoft/test"
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
$url = 'http://booking-system.com/api/v1/webhooks/microsoft/test';
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

url = 'http://booking-system.com/api/v1/webhooks/microsoft/test'
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-webhooks-microsoft-test">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Webhook endpoint is accessible&quot;,
    &quot;timestamp&quot;: &quot;2025-10-03T15:40:21.002184Z&quot;,
    &quot;url&quot;: &quot;http://booking-system.com/api/v1/webhooks/microsoft/test&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-webhooks-microsoft-test" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-webhooks-microsoft-test"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-webhooks-microsoft-test"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-webhooks-microsoft-test" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-webhooks-microsoft-test">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-webhooks-microsoft-test" data-method="GET"
      data-path="api/v1/webhooks/microsoft/test"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-webhooks-microsoft-test', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-webhooks-microsoft-test"
                    onclick="tryItOut('GETapi-v1-webhooks-microsoft-test');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-webhooks-microsoft-test"
                    onclick="cancelTryOut('GETapi-v1-webhooks-microsoft-test');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-webhooks-microsoft-test"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/webhooks/microsoft/test</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-webhooks-microsoft-test"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-webhooks-microsoft-test"
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
                              name="Accept"                data-endpoint="GETapi-v1-webhooks-microsoft-test"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="webhooks-GETapi-v1-webhooks-microsoft-status">Get webhook subscription status.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-webhooks-microsoft-status">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/webhooks/microsoft/status" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/webhooks/microsoft/status"
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
$url = 'http://booking-system.com/api/v1/webhooks/microsoft/status';
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

url = 'http://booking-system.com/api/v1/webhooks/microsoft/status'
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('GET', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-webhooks-microsoft-status">
            <blockquote>
            <p>Example response (401):</p>
        </blockquote>
                <details class="annotation">
            <summary style="cursor: pointer;">
                <small onclick="textContent = parentElement.parentElement.open ? 'Show headers' : 'Hide headers'">Show headers</small>
            </summary>
            <pre><code class="language-http">cache-control: no-cache, private
content-type: application/json
access-control-allow-origin: *
 </code></pre></details>         <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;message&quot;: &quot;Unauthenticated.&quot;
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-webhooks-microsoft-status" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-webhooks-microsoft-status"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-webhooks-microsoft-status"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-webhooks-microsoft-status" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-webhooks-microsoft-status">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-webhooks-microsoft-status" data-method="GET"
      data-path="api/v1/webhooks/microsoft/status"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-webhooks-microsoft-status', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-webhooks-microsoft-status"
                    onclick="tryItOut('GETapi-v1-webhooks-microsoft-status');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-webhooks-microsoft-status"
                    onclick="cancelTryOut('GETapi-v1-webhooks-microsoft-status');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-webhooks-microsoft-status"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/webhooks/microsoft/status</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="GETapi-v1-webhooks-microsoft-status"
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
                              name="Content-Type"                data-endpoint="GETapi-v1-webhooks-microsoft-status"
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
                              name="Accept"                data-endpoint="GETapi-v1-webhooks-microsoft-status"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="webhooks-POSTapi-v1-webhooks-microsoft-subscribe">Create or refresh webhook subscription.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-webhooks-microsoft-subscribe">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/webhooks/microsoft/subscribe" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/webhooks/microsoft/subscribe"
);

const headers = {
    "Authorization": "Bearer Bearer {YOUR_SANCTUM_TOKEN}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>


<div class="php-example">
    <pre><code class="language-php">$client = new \GuzzleHttp\Client();
$url = 'http://booking-system.com/api/v1/webhooks/microsoft/subscribe';
$response = $client-&gt;post(
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

url = 'http://booking-system.com/api/v1/webhooks/microsoft/subscribe'
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('POST', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-webhooks-microsoft-subscribe">
</span>
<span id="execution-results-POSTapi-v1-webhooks-microsoft-subscribe" hidden>
    <blockquote>Received response<span
                id="execution-response-status-POSTapi-v1-webhooks-microsoft-subscribe"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-v1-webhooks-microsoft-subscribe"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-POSTapi-v1-webhooks-microsoft-subscribe" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-v1-webhooks-microsoft-subscribe">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-POSTapi-v1-webhooks-microsoft-subscribe" data-method="POST"
      data-path="api/v1/webhooks/microsoft/subscribe"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('POSTapi-v1-webhooks-microsoft-subscribe', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-POSTapi-v1-webhooks-microsoft-subscribe"
                    onclick="tryItOut('POSTapi-v1-webhooks-microsoft-subscribe');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-POSTapi-v1-webhooks-microsoft-subscribe"
                    onclick="cancelTryOut('POSTapi-v1-webhooks-microsoft-subscribe');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-POSTapi-v1-webhooks-microsoft-subscribe"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-black">POST</small>
            <b><code>api/v1/webhooks/microsoft/subscribe</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="POSTapi-v1-webhooks-microsoft-subscribe"
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
                              name="Content-Type"                data-endpoint="POSTapi-v1-webhooks-microsoft-subscribe"
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
                              name="Accept"                data-endpoint="POSTapi-v1-webhooks-microsoft-subscribe"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="webhooks-DELETEapi-v1-webhooks-microsoft-unsubscribe">Remove webhook subscription.</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-v1-webhooks-microsoft-unsubscribe">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://booking-system.com/api/v1/webhooks/microsoft/unsubscribe" \
    --header "Authorization: Bearer Bearer {YOUR_SANCTUM_TOKEN}" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/webhooks/microsoft/unsubscribe"
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
$url = 'http://booking-system.com/api/v1/webhooks/microsoft/unsubscribe';
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

url = 'http://booking-system.com/api/v1/webhooks/microsoft/unsubscribe'
headers = {
  'Authorization': 'Bearer Bearer {YOUR_SANCTUM_TOKEN}',
  'Content-Type': 'application/json',
  'Accept': 'application/json'
}

response = requests.request('DELETE', url, headers=headers)
response.json()</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-webhooks-microsoft-unsubscribe">
</span>
<span id="execution-results-DELETEapi-v1-webhooks-microsoft-unsubscribe" hidden>
    <blockquote>Received response<span
                id="execution-response-status-DELETEapi-v1-webhooks-microsoft-unsubscribe"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-v1-webhooks-microsoft-unsubscribe"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-DELETEapi-v1-webhooks-microsoft-unsubscribe" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-v1-webhooks-microsoft-unsubscribe">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-DELETEapi-v1-webhooks-microsoft-unsubscribe" data-method="DELETE"
      data-path="api/v1/webhooks/microsoft/unsubscribe"
      data-authed="1"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('DELETEapi-v1-webhooks-microsoft-unsubscribe', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-DELETEapi-v1-webhooks-microsoft-unsubscribe"
                    onclick="tryItOut('DELETEapi-v1-webhooks-microsoft-unsubscribe');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-DELETEapi-v1-webhooks-microsoft-unsubscribe"
                    onclick="cancelTryOut('DELETEapi-v1-webhooks-microsoft-unsubscribe');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-DELETEapi-v1-webhooks-microsoft-unsubscribe"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-red">DELETE</small>
            <b><code>api/v1/webhooks/microsoft/unsubscribe</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Authorization</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Authorization" class="auth-value"               data-endpoint="DELETEapi-v1-webhooks-microsoft-unsubscribe"
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
                              name="Content-Type"                data-endpoint="DELETEapi-v1-webhooks-microsoft-unsubscribe"
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
                              name="Accept"                data-endpoint="DELETEapi-v1-webhooks-microsoft-unsubscribe"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
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
