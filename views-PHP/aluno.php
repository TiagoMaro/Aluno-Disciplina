<html>

<head>
  <title>Cadastro de Alunos</title>


  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
  <?php include('config.php');
  if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
  }

  $query_municipio = "SELECT codigo, nomem FROM municipio ORDER BY nomem";
  $result_municipio = mysqli_query($mysqli, $query_municipio);

  if (!$result_municipio) {
    die("Erro na query de municipio: " . $mysqli->error);
  }
  ?>
  <form action="aluno.php" method="post" name="aluno">
    <table width="200" border="1">
      <tr>
        <td colspan="2">Cadastro de Alunos</td>
      </tr>
      <tr>
        <td>Nome:</td>
        <td><input type="text" name="nome"></td>
      </tr>
      <tr>
        <td>Mora:</td>
        <td>
          <select name="fk_municipio_codigo" required>
            <option value="">Selecione um municipio</option>
            <?php
            if ($result_municipio && mysqli_num_rows($result_municipio) > 0) {
              mysqli_data_seek($result_municipio, 0);
              while ($row = mysqli_fetch_assoc($result_municipio)): ?>
                <option value="<?php echo $row['codigo']; ?>"><?php echo htmlspecialchars($row['nomem']); ?></option>
              <?php endwhile;
            } else {
              echo '<option value="">Nenhum municipio encontrado</option>';
            }
            ?>
          </select>
        </td>
      </tr>
      <td colspan="2" align="right"><input type="submit" value="Gravar" name="botao"></td>
      </tr>
    </table>
  </form>
  <?php
  if (@$_POST['botao'] == "Gravar") {

    $nome = $_POST['nome'];
    $cod_municipio = $_POST['fk_municipio_codigo'];

    $insere = "INSERT into aluno(nomea, fk_municipio_codigo) VALUES ('$nome', '$cod_municipio')";
    mysqli_query($mysqli, $insere) or die("Não foi possivel inserir os dados");
  }
  ?>
  <a href="../index.html">Home </a>
</body>

</html>