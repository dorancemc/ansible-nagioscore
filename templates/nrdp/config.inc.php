<?php
{% for key, value in nrdp_config_php.items() %}
{% if ( value is iterable ) and ( value is not string ) %}
$cfg["{{ key }}"] = array(
{% if value|length>0 %}
{% if key == 'external_commands_deny_tokens' %}
{% for data in value %}
{% for key1, value1 in data.items() %}
    "{{ key1 }}" => array({{ value1 }}),
{% endfor %}
{% endfor %}
{% else %}
{% for data in value %}
    "{{ data }}",
{% endfor %}
{% endif %}
{% endif %}
);
{% else %}
{% if value is boolean %}
$cfg["{{ key }}"] = {{ value|lower }};
{% else%}
$cfg["{{ key }}"] = "{{ value }}";
{% endif %}
{% endif %}
{% endfor %}
