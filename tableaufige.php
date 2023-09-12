<!DOCTYPE html>
<html>
<head>
  <title>Tableau avec entête figé</title>
  <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <style>
        table.sticky-header {
  width: 100%;
  border-collapse: collapse;
}

table.sticky-header th {
  background-color: #f2f2f2;
  position: sticky;
  top: 0;
}

table.sticky-header th, table.sticky-header td {
  padding: 10px;
  border: 1px solid #ccc;
}

    </style>
<div style="height: 200px; overflow:auto;">

    <table class="sticky-header">
        <thead>
        <tr>
            <th>Nom</th>
            <th>Âge</th>
            <th>Ville</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>John Doe</td>
            <td>30</td>
            <td>New York</td>
        </tr>
        <tr>
            <td>John Doe</td>
            <td>30</td>
            <td>New York</td>
        </tr>
        <tr>
            <td>John Doe</td>
            <td>30</td>
            <td>New York</td>
        </tr>
        <tr>
            <td>John Doe</td>
            <td>30</td>
            <td>New York</td>
        </tr>
        <tr>
            <td>John Doe</td>
            <td>30</td>
            <td>New York</td>
        </tr>
        <tr>
            <td>John Doe</td>
            <td>30</td>
            <td>New York</td>
        </tr>
        <!-- Autres lignes du tableau -->
        </tbody>
    </table>
</div>
</body>
</html>
