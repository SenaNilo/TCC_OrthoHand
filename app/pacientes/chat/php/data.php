<?php
      while($row = mysqli_fetch_assoc($sql)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$unique_id}
                  OR outgoing_msg_id = {$unique_id}) AND (outgoing_msg_id = {$row['unique_id']}
                  OR incoming_msg_id = {$row['unique_id']}) ORDER BY msg_id DESC LIMIT 1";

        $query2 = mysqli_query($conexao, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        if(mysqli_num_rows($query2) > 0){
          $result = $row2['msg'];
        }else{
          $result = "Não há mensagens";
        }

        //Se a palavra tiver mais de 28 letras, ele corta a mensagem
        (strlen($result) > 28) ? $msg = substr($result, 0, 28).'...' : $msg = $result;

        // ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        
        // ($row['status'] == "Offline") ? $offline = "offline" : $offline = "";
        if($row['img'] == null){
          $img = "fotoperfilvazia.jpg";
        }else{
          $img = $row['img'];
        }

        $output .= '<a href = "chat.php?id_usuario='.$row['unique_id'].'" >
        <div class = "content">
        <img src = "../../fotos/'.$img.'" alt = "">
        <div class = "details">
            <span>'. $row['nome'].'</span>
            <p>'.$result.'</p>
        </div>
        </div>
        <div class = "status-dot">
          <i class ="fas fa-circle"></i>
        </div>
      </a>';
}
?>
