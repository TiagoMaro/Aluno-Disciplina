<html>

<head>
  <title>Relatório de Matrículas</title>
  <?php include('config.php'); ?>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
  <form action="cursalst.php" method="post" name="form1">
    <table width="95%" border="1" align="center">
      <tr>
        <td colspan="5" align="center">Relatório de Matrículas</td>
      </tr>
      <tr>
        <td width="9%" align="right">Nome Aluno:</td>
        <td width="30%"><input type="text" name="nomea" /></td>
        <td width="12%" align="right">Nome Disciplina:</td>
        <td width="26%"><input type="text" name="nomed" /></td>
        <td width="21%"><input type="submit" name="botao" value="Gerar" /></td>
      </tr>
    </table>
  </form>

  <?php if (isset($_POST['botao']) && $_POST['botao'] == "Gerar") { ?>

    <table width="95%" border="1" align="center">
      <tr bgcolor="#9999FF">
        <th width="25%">Nome do Aluno</th>
        <th width="20%">Nome da Disciplina</th>
        <th width="20%">Nome do Municipio</th>
        <th width="20%">Nome do Professor</th>
        <th width="10%">Nota 1º Bimestre</th>
        <th width="10%">Nota 2º Bimestre</th>
        <th width="10%">Média</th>
      </tr>

      <?php
      $nomea = isset($_POST['nomea']) ? $_POST['nomea'] : '';
      $nomed = isset($_POST['nomed']) ? $_POST['nomed'] : '';

      $query = "SELECT a.nomea, d.nomed, m.nomem, p.nomep, c.nota1, c.nota2, 
                     FORMAT((c.nota1 + c.nota2)/2, 1) as media
              FROM CURSA c
              INNER JOIN ALUNO a ON c.FK_ALUNO_matricula = a.matricula
              INNER JOIN DISCIPLINA d ON c.FK_DISCIPLINA_codigo = d.codigo
              INNER JOIN MUNICIPIO m ON a.FK_MUNICIPIO_codigo = m.codigo
              INNER JOIN PROFESSOR p ON d.FK_PROFESSOR_matricula = p.matricula
              WHERE 1=1 ";

      if (!empty($nomea)) {
        $query .= " AND a.nomea LIKE '%" . mysqli_real_escape_string($mysqli, $nomea) . "%'";
      }
      if (!empty($nomed)) {
        $query .= " AND d.nomed LIKE '%" . mysqli_real_escape_string($mysqli, $nomed) . "%'";
      }

      $query .= " ORDER BY a.nomea, d.nomed";

      $result = mysqli_query($mysqli, $query);

      if ($result && mysqli_num_rows($result) > 0) {
        while ($coluna = mysqli_fetch_array($result)) {
          ?>
          <tr>
            <td><?php echo htmlspecialchars($coluna['nomea']); ?></td>
            <td><?php echo htmlspecialchars($coluna['nomed']); ?></td>
            <td><?php echo htmlspecialchars($coluna['nomem']); ?></td>
            <td><?php echo htmlspecialchars($coluna['nomep']); ?></td>
            <td><?php echo htmlspecialchars($coluna['nota1']); ?></td>
            <td><?php echo htmlspecialchars($coluna['nota2']); ?></td>
            <td><?php echo htmlspecialchars($coluna['media']); ?></td>
          </tr>
          <?php
        }
      } else {
        echo "<tr><td colspan='7' align='center'>Nenhum registro encontrado</td></tr>";
      }
      ?>
    </table>
    <?php
  }
  ?>
  <a href="../index.html">Home </a>
</body>

</html>