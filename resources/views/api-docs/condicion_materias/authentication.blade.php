                        <tr>
                            <td>Autorización</td>
                            <td>String</td>
                            <td>
                                <span class="label label-primary" title="Este parámetro es un encabezado HTTP">Header</span>
                            </td>
                            <td>El token de acceso prefijado con la palabra clave "Bearer ".</td>
                            @if(isset($showValidation) && $showValidation)
                                <td></td>
                            @endif
                        </tr>
