{% extends "core/main.twig.php" %}

{% block title %} Minhas Receitas {% endblock %}

{% block head %}
<link href="{{BASE}}vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
{% endblock %}


{% block body %}
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Email</th>
                        <th>Ações</th>                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Email</th>                      
                        <th>Ações</th>                        
                    </tr>
                </tfoot>
                <tbody>
                    {% for usuario in response.data.usuarios %}        
                    <tr>
                        <td>{{usuario.nome}}</td>
                        <td>{{usuario.sobrenome}}</td>
                        <td>{{usuario.email}}</td>
                        <td>
                            <a href="{{BASE}}usuario/view/{{ usuario.id }}" class="btn btn-warning">Editar</a>
                            <a href="{{BASE}}usuario/delete/{{ usuario.id }}" class="btn btn-danger ml-2">Excluir</a>
                        </td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>
    </div>
</div>

{% endblock %}

{% block scripts %}

    <!-- Page level plugins -->
    <script src="{{BASE}}vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="{{BASE}}vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{BASE}}js/demo/datatables-demo.js"></script>

{% endblock %}