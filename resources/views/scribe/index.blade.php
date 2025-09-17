<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Booking-System API Documentation</title>

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
            </style>

    <script>
        var tryItOutBaseUrl = "http://booking-system.com";
        var useCsrf = Boolean();
        var csrfUrl = "";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.3.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.3.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

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
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-booking-system" class="tocify-header">
                <li class="tocify-item level-1" data-unique="booking-system">
                    <a href="#booking-system">Booking System</a>
                </li>
                                    <ul id="tocify-subheader-booking-system" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="booking-system-GETapi-v1-resources">
                                <a href="#booking-system-GETapi-v1-resources">GET api/v1/resources</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="booking-system-GETapi-v1-resources--resource--availability">
                                <a href="#booking-system-GETapi-v1-resources--resource--availability">GET api/v1/resources/{resource}/availability</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="booking-system-POSTapi-v1-bookings">
                                <a href="#booking-system-POSTapi-v1-bookings">POST api/v1/bookings</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="booking-system-GETapi-v1-bookings--booking_id-">
                                <a href="#booking-system-GETapi-v1-bookings--booking_id-">GET api/v1/bookings/{booking_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="booking-system-PUTapi-v1-bookings--booking_id-">
                                <a href="#booking-system-PUTapi-v1-bookings--booking_id-">PUT api/v1/bookings/{booking_id}</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="booking-system-DELETEapi-v1-bookings--booking_id-">
                                <a href="#booking-system-DELETEapi-v1-bookings--booking_id-">DELETE api/v1/bookings/{booking_id}</a>
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
        <li>Last updated: September 17, 2025</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<p>API documentation for the Booking System.</p>
<aside>
    <strong>Base URL</strong>: <code>http://booking-system.com</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>To authenticate requests, include an <strong><code>Authorization</code></strong> header with the value <strong><code>"Bearer {YOUR_BEARER_TOKEN}"</code></strong>.</p>
<p>All authenticated endpoints are marked with a <code>requires authentication</code> badge in the documentation below.</p>

        <h1 id="booking-system">Booking System</h1>

    

                                <h2 id="booking-system-GETapi-v1-resources">GET api/v1/resources</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-resources">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/resources" \
    --header "Authorization: Bearer {YOUR_BEARER_TOKEN}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/resources"
);

const headers = {
    "Authorization": "Bearer {YOUR_BEARER_TOKEN}",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-resources">
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
               value="Bearer {YOUR_BEARER_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_BEARER_TOKEN}</code></p>
            </div>
                        </form>

                    <h2 id="booking-system-GETapi-v1-resources--resource--availability">GET api/v1/resources/{resource}/availability</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-resources--resource--availability">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/resources/{resource}/availability" \
    --header "Authorization: Bearer {YOUR_BEARER_TOKEN}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/resources/{resource}/availability"
);

const headers = {
    "Authorization": "Bearer {YOUR_BEARER_TOKEN}",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-resources--resource--availability">
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
               value="Bearer {YOUR_BEARER_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_BEARER_TOKEN}</code></p>
            </div>
                        </form>

                    <h2 id="booking-system-POSTapi-v1-bookings">POST api/v1/bookings</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-POSTapi-v1-bookings">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request POST \
    "http://booking-system.com/api/v1/bookings" \
    --header "Authorization: Bearer {YOUR_BEARER_TOKEN}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/bookings"
);

const headers = {
    "Authorization": "Bearer {YOUR_BEARER_TOKEN}",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-POSTapi-v1-bookings">
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
               value="Bearer {YOUR_BEARER_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_BEARER_TOKEN}</code></p>
            </div>
                        </form>

                    <h2 id="booking-system-GETapi-v1-bookings--booking_id-">GET api/v1/bookings/{booking_id}</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-GETapi-v1-bookings--booking_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://booking-system.com/api/v1/bookings/{booking_id}" \
    --header "Authorization: Bearer {YOUR_BEARER_TOKEN}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/bookings/{booking_id}"
);

const headers = {
    "Authorization": "Bearer {YOUR_BEARER_TOKEN}",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-bookings--booking_id-">
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
               value="Bearer {YOUR_BEARER_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_BEARER_TOKEN}</code></p>
            </div>
                        </form>

                    <h2 id="booking-system-PUTapi-v1-bookings--booking_id-">PUT api/v1/bookings/{booking_id}</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-PUTapi-v1-bookings--booking_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request PUT \
    "http://booking-system.com/api/v1/bookings/{booking_id}" \
    --header "Authorization: Bearer {YOUR_BEARER_TOKEN}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/bookings/{booking_id}"
);

const headers = {
    "Authorization": "Bearer {YOUR_BEARER_TOKEN}",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-PUTapi-v1-bookings--booking_id-">
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
               value="Bearer {YOUR_BEARER_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_BEARER_TOKEN}</code></p>
            </div>
                        </form>

                    <h2 id="booking-system-DELETEapi-v1-bookings--booking_id-">DELETE api/v1/bookings/{booking_id}</h2>

<p>
<small class="badge badge-darkred">requires authentication</small>
</p>



<span id="example-requests-DELETEapi-v1-bookings--booking_id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request DELETE \
    "http://booking-system.com/api/v1/bookings/{booking_id}" \
    --header "Authorization: Bearer {YOUR_BEARER_TOKEN}"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://booking-system.com/api/v1/bookings/{booking_id}"
);

const headers = {
    "Authorization": "Bearer {YOUR_BEARER_TOKEN}",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-DELETEapi-v1-bookings--booking_id-">
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
               value="Bearer {YOUR_BEARER_TOKEN}"
               data-component="header">
    <br>
<p>Example: <code>Bearer {YOUR_BEARER_TOKEN}</code></p>
            </div>
                        </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
