<html>

<head>
  <title>Matrícula de Alunos</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
  <?php
  include('config.php');

  // Verificar conexão
  if ($mysqli->connect_error) {
    die("Erro de conexão: " . $mysqli->connect_error);
  }

  // Buscar alunos do banco de dados
  $query_alunos = "SELECT matricula, nomea FROM aluno ORDER BY nomea";
  $result_alunos = mysqli_query($mysqli, $query_alunos);

  // Buscar disciplinas do banco de dados
  $query_disciplinas = "SELECT codigo, nomed FROM disciplina ORDER BY nomed";
  $result_disciplinas = mysqli_query($mysqli, $query_disciplinas);

  // Verificar erros nas queries
  if (!$result_alunos) {
    die("Erro na query de alunos: " . $mysqli->error);
  }

  if (!$result_disciplinas) {
    die("Erro na query de disciplinas: " . $mysqli->error);
  }
  ?>

  <form action="cursa.php" method="post" name="aluno">
    <table width="200" border="1">
      <tr>
        <td colspan="2">Matrícula de Alunos</td>
      </tr>
      <tr>
        <td>Data Matrícula:</td>
        <td><input type="date" name="data_matricula" required></td>
      </tr>
      <tr>
        <td>Nota 1:</td>
        <td><input type="number" name="nota1" step="0.1" min="0" max="10" required></td>
      </tr>
      <tr>
        <td>Nota 2:</td>
        <td><input type="number" name="nota2" step="0.1" min="0" max="10" required></td>
      </tr>
      <tr>
        <td>Aluno:</td>
        <td>
          <select name="FK_ALUNO_matricula" required>
            <option value="">Selecione um aluno</option>
            <?php
            if ($result_alunos && mysqli_num_rows($result_alunos) > 0) {
              while ($row = mysqli_fetch_assoc($result_alunos)): ?>
                <option value="<?php echo $row['matricula']; ?>"><?php echo htmlspecialchars($row['nomea']); ?></option>
              <?php endwhile;
            } else {
              echo '<option value="">Nenhum aluno encontrado</option>';
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td>Disciplina:</td>
        <td>
          <select name="FK_DISCIPLINA_codigo" required>
            <option value="">Selecione uma disciplina</option>
            <?php
            if ($result_disciplinas && mysqli_num_rows($result_disciplinas) > 0) {
              mysqli_data_seek($result_disciplinas, 0);
              while ($row = mysqli_fetch_assoc($result_disciplinas)): ?>
                <option value="<?php echo $row['codigo']; ?>"><?php echo htmlspecialchars($row['nomed']); ?></option>
              <?php endwhile;
            } else {
              echo '<option value="">Nenhuma disciplina encontrada</option>';
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2" align="right"><input type="submit" value="Gravar" name="botao"></td>
      </tr>
    </table>
  </form>

  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['botao']) && $_POST['botao'] == "Gravar") {
    // Validação dos dados
    $data = $_POST['data_matricula'] ?? '';
    $nota1 = filter_input(
      INPUT_POST,
      'nota1',
      FILTER_VALIDATE_FLOAT,
      ['options' => ['min_range' => 0, 'max_range' => 10]]
    );
    $nota2 = filter_input(
      INPUT_POST,
      'nota2',
      FILTER_VALIDATE_FLOAT,
      ['options' => ['min_range' => 0, 'max_range' => 10]]
    );
    $matricula = filter_input(INPUT_POST, 'FK_ALUNO_matricula', FILTER_VALIDATE_INT);
    $codigo = filter_input(INPUT_POST, 'FK_DISCIPLINA_codigo', FILTER_VALIDATE_INT);

    if ($data && $nota1 !== false && $nota2 !== false && $matricula && $codigo) {
      $stmt = $mysqli->prepare("INSERT INTO CURSA (data_matricula, nota1, nota2, FK_ALUNO_matricula, FK_DISCIPLINA_codigo) 
                                 VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("sddii", $data, $nota1, $nota2, $matricula, $codigo);

      if ($stmt->execute()) {
        echo "<p style='color:green;'>Matrícula cadastrada com sucesso!</p>";
      } else {
        echo "<p style='color:red;'>Erro ao cadastrar matrícula: " . htmlspecialchars($mysqli->error) . "</p>";
      }
      $stmt->close();
    } else {
      echo "<p style='color:red;'>Por favor, preencha todos os campos corretamente!</p>";
    }
  }
  ?>
  <a href="../index.html">Home </a>
</body>

</html>