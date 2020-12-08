{% if response.message.success == true and response.message.description is not empty %}
<div class="alert alert-success" role="alert">
    {{response.message.description}}
</div>
{% endif %}

{% if response.message.success == false and response.message.description is not empty %}
<div class="alert alert-danger" role="alert">
    {{response.message.description}}
</div>
{% endif %}