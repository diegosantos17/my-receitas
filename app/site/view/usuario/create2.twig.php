{% extends "core/main.twig.php" %}

{% block title %} Minhas Receitas {% endblock %}

{% block head %}
<link href="{{BASE}}vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
{% endblock %}


{% block body %}
<form method="POST" action="{{BASE}}usuario/create2">
    <div class="form-group row">
        <label for="nome" class="col-sm-2 col-form-label">Nome</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="nome" name="nome" value="" required>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="sobrenome" class="col-sm-2 col-form-label">Sobrenome</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="nome" name="sobrenome" value="" required>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" id="email" name="email" value="" required>
        </div>
    </div>
    
    <div class="form-group row">
        <label for="senha" class="col-sm-2 col-form-label">Senha</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="senha" name="senha" value="" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="confirmarsenha" class="col-sm-2 col-form-label">Confirmar Senha</label>
        <div class="col-sm-10">
            <input type="password" class="form-control" id="confirmarsenha" name="confirmarsenha" value="" required>
        </div>
    </div>

    <div class="form-group row justify-content-end">
        <div class="col-2">
            <a href="{{BASE}}usuario" class="btn btn-info">Voltar</a>
        </div>
        <div class="col-2">
            <input type="submit" class="btn btn-primary" value="Salvar" />
        </div>
    </div>
</form>

{% endblock %}

{% block scripts %}

{% endblock %}