<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
    <body>
        Olá {{ $nameUser }}, uma nova despesa foi registrada em {{ $createdExpense }}
        
        <br/><br/>

        <table border="1px" width="500px">
            <tr>
                <td>Descrição</td>
                <td>{{ $descriptionExpense }}</td>
            </tr>
            <tr>
                <td>Data da despesa</td>
                <td>{{ $dateExpense }}</td>
            </tr>
            <tr>
                <td>Valor da despesa</td>
                <td>{{ $valueExpense }}</td>
            </tr>
        </table>
    </body>
</html>