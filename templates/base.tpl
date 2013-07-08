<!DOCTYPE html>
<html xmlns="https://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
    <link rel="stylesheet" type="text/css" href="/assets/css/base.css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/smoothness/jquery-ui-1.10.1.custom.min.css" />
    <script type="text/javascript" src="/assets/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/jquery-ui-1.10.1.custom.min.js"></script>
    {% block name="head" %}{% /block %}
    <title>{% if isset($title) %}{% $title %}{% /if %}</title>
</head>
<body{% if isset($page) %} id="{% $page %}"{% /if %}>
    <div id="header">
        <div id="colorbar"></div>
        Origami Chandelier
    </div>
    <div id="content">
        {% block name="content" %}{% /block %}
    </div>
</body>
</html>
