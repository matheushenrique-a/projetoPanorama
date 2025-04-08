<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Minha Carteirinha</title>
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  <meta name="description" content="Veja como é fácil receber sua carteirinha.">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background-color: white; text-align: center; font-family: Arial, sans-serif; padding: 10vh 5vw;">

  <h1 style="font-size: 8vw; color: #333; margin-bottom: 1vh;">Olá <?php echo $fname;?>,</h1>
  <p style="font-size: 4.5vw; color: #555; margin-bottom: 8vh; margin-top: 0px;">Tudo certo para iniciarmos.</p>

  <button 
    onclick="window.open('<?php echo $linkKompletoCliente;?>', '_blank')" 
    style="width: 80%; max-width: 400px; padding: 5vw 0; font-size: 5vw; background-color: #007BFF; color: white; border: none; border-radius: 10px; cursor: pointer; margin-bottom: 5vh;">
    Começar
  </button>

  <br>

  <button 
    onclick="window.open('<?php echo $linkMeeting;?>')" 
    style="width: 80%; max-width: 400px; padding: 5vw 0; font-size: 5vw; margin-top: 3vh; background-color: #28a745; color: white; border: none; border-radius: 10px; cursor: pointer;">
    Ajuda
  </button>

  <button 
    onclick="window.location.reload();" 
    style="width: 80%; max-width: 400px; padding: 3vw 0; font-size: 5vw; background-color:rgb(227, 227, 227); color: black; border: none; border-radius: 10px; cursor: pointer; margin-top: 12vh;">
    Atualizar
  </button>

</body>
</html>