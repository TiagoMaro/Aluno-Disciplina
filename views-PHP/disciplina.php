<html>

<head>
  <title>Cadastro de Disciplinas</title>


  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
  <?php
  include('config.php');

  $query_professor = "SELECT matricula, nomep FROM professor ORDER BY nomep";
  $result_professor = mysqli_query($mysqli, $query_professor);


  if (!$result_professor) {
    die("Erro na query de professor" . $mysqli->error);
  }
  ?>
  <form action="disciplina.php" method="post" name="aluno">
    <table width="200" border="1">
      <tr>
        <td colspan="2">Cadastro de Disciplinas</td>
      </tr>
      <tr>
        <td>Disciplina:</td>
        <td><input type="text" name="nome"></td>
      </tr>
      <tr>
        <td>Matricula Professor:</td>
        <td>
          <select name="nome_professor" required>
            <option value=""> Selecione Professor</option>
            <?php
            if ($result_professor && mysqli_num_rows($result_professor) > 0) {
              while ($row = mysqli_fetch_assoc($result_professor)): ?>
                <option value="<?php echo $row['matricula']; ?>"><?php echo htmlspecialchars($row['nomep']); ?></option>
              <?php endwhile;
            } else {
              echo '<option value="">Nenhum professor encontrado</option>';
            }
            ?>
          </select>
      </tr>
      <td colspan="2" align="right"><input type="submit" value="Gravar" name="botao"></td>
      </tr>
    </table>
  </form>
  <?php
  if (@$_POST['botao'] == "Gravar") {

    $nome = $_POST['nome'];
    $nome_professor = $_POST['nome_professor'];

    $insere = "INSERT into disciplina (nomed, FK_PROFESSOR_matricula) VALUES ('$nome', '$nome_professor')";
    mysqli_query($mysqli, $insere) or die("Não foi possivel inserir os dados");
  }
  ?>
  <a href="../index.html">Home </a>
</body>

</html>