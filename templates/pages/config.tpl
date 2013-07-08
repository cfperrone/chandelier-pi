{% extends file="base.tpl" %}

{% block name="content" %}
<h1>Current Runtime Configuration</h1>
<table border="1">
    <thead>
        <th>Key</th>
        <th>Value</th>
    </thead>
    <tbody>
        {% foreach from=$config key=k item=v %}
        <tr>
            <td>{% $k %}</td>
            <td>{% $v %}</td>
        </tr>
        {% /foreach %}
    </tbody>
</table>

{% /block %}
