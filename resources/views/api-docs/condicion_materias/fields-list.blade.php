<?php
$showValidation = (isset($withValidation) && $withValidation) ? true : false;
?>
<table class="table table-stripped">
    <thead>
        <tr>
            <th>Parameter Name</th>
            <th>Data Type</th>
            <th>Parameter Type</th>
            <th>Description</th>
            @if($showValidation)
                <th>Validation</th>
            @endif
        </tr>
    </thead>
    <tbody>
        
        @if(isset($withPathId) && $withPathId)
        <tr>
            <td>condicion materia</td>
            <td>Primary Key</td>
            <td><span class="label label-info" title="This parameter is part of the url">Path</span></td>
            <td>The id of the condicion materia.</td>
            @if($showValidation)
                <td>
                    <span class="label label-danger" title="This parameter must be present in the request.">Required</span>
                </td>
            @endif
        </tr>

        @endif

                <tr>
            <td>id</td>
            <td>String</td>
            <td><span class="label label-default" title="This parameter is part of the body">Body</span></td>
            <td>The id of the model.</td>
            @if($showValidation)
                <td>
                    
                    <span></span>
                </td>
            @endif
        </tr>

        <tr>
            <td>nombre</td>
            <td>String</td>
            <td><span class="label label-default" title="This parameter is part of the body">Body</span></td>
            <td>The nombre of the model.</td>
            @if($showValidation)
                <td>
                    <span class="label label-danger" title="This parameter must be present in the request.">Required</span>
                    <span>String; Minimum Length: ; Maximum Length: </span>
                </td>
            @endif
        </tr>

        <tr>
            <td>identificador</td>
            <td>String</td>
            <td><span class="label label-default" title="This parameter is part of the body">Body</span></td>
            <td>The identificador of the model.</td>
            @if($showValidation)
                <td>
                    <span class="label label-danger" title="This parameter must be present in the request.">Required</span>
                    <span>String; Minimum Length: ; Maximum Length: </span>
                </td>
            @endif
        </tr>

        <tr>
            <td>habilitado</td>
            <td>Boolean</td>
            <td><span class="label label-default" title="This parameter is part of the body">Body</span></td>
            <td>The habilitado of the model.</td>
            @if($showValidation)
                <td>
                    
                    <span>Boolean</span>
                </td>
            @endif
        </tr>

        <tr>
            <td>operador id</td>
            <td>String</td>
            <td><span class="label label-default" title="This parameter is part of the body">Body</span></td>
            <td>The operador of the model.</td>
            @if($showValidation)
                <td>
                    <span class="label label-danger" title="This parameter must be present in the request.">Required</span>
                    <span></span>
                </td>
            @endif
        </tr>

        <tr>
            <td>deleted at</td>
            <td>DateTime</td>
            <td><span class="label label-default" title="This parameter is part of the body">Body</span></td>
            <td>The deleted at of the model.</td>
            @if($showValidation)
                <td>
                    
                    <span></span>
                </td>
            @endif
        </tr>

        <tr>
            <td>created at</td>
            <td>DateTime</td>
            <td><span class="label label-default" title="This parameter is part of the body">Body</span></td>
            <td>The created at of the model.</td>
            @if($showValidation)
                <td>
                    
                    <span></span>
                </td>
            @endif
        </tr>

        <tr>
            <td>updated at</td>
            <td>DateTime</td>
            <td><span class="label label-default" title="This parameter is part of the body">Body</span></td>
            <td>The updated at of the model.</td>
            @if($showValidation)
                <td>
                    
                    <span></span>
                </td>
            @endif
        </tr>


    </tbody>

</table>
