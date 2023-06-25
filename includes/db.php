<?php 
// $data = [] => select
function query($sql, $data = [], $statementStatus = false){
    global $connection;
    $query = false;

    try{
        $statement = $connection->prepare($sql);
        if(empty($data)){
            $query = $statement->execute();
        }else{
            $query = $statement->execute($data);
        }

    }catch(Exception $e){
        require_once 'modules/errors/db_error.php';
        die();
    }

    if($statementStatus && $query){
        return $statement;
    }else{
        return $query;
    }
}

function insert($table, $data){
    // $sql = 'insert into $table ($key1, $key2, ..., $keyn) values (?,?,..?)';

    $keysArr = array_keys($data);
    $valuesArr = array_values($data);

    // ($key1, $key2, ..., $keyn)
    $keysString = implode(',', $keysArr);
    
    // (?,?,...?)
    $marksString = implode(',', array_fill(0, count($keysArr), '?'));

    $sql = "INSERT INTO $table ($keysString) VALUES ($marksString)";
    
    return query($sql, $valuesArr);
}



function update($table, $data, $id){
    // sql = update $table set key1 = ?, key2 = ? WHERE id = ?

    // sql = UPDATE $table SET key1 = :key1, key2 = :key2 WHERE id = :id
    // $data là assoc array vs key giống với trường dc update trong table

    $keysArr = array_keys($data);
    $keysString = '';
    foreach($keysArr as $key){
        $keysString .= $key .'=:' .$key .', ';
    }
    $keysString = rtrim($keysString, ', ');
    $data['id'] = $id;
   
    $sql = "UPDATE $table SET $keysString WHERE id =:id";
    return query($sql, $data);

}
// update('users', ['fullname' => 'ben ben', 'email' => 'benben@gmail.com'], 2);

function delete($table, $key, $valueKey){
    // sql = DELETE FROM $table WHERE id=? 
    $sql = "DELETE FROM $table WHERE $key = ?";
    return query($sql, [$valueKey]);
}
// delete('users', 2);

// lấy ra toàn bộ dữ liệu
function getRaw($sql, $data){
    $statement = query($sql, $data, true);

    if(is_object($statement)){
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }else 
        return false;
    
}

// lấy ra 1 bản ghi 
function firstRaw($sql, $data = null){
    $statement = query($sql, $data, true);
    if(is_object($statement)){
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }else 
        return false;
}

// đếm record của 1 truy vấn 
function getRows($sql, $data){
    $statement = query($sql, $data, true);
    if(!empty($statement)){
        return $statement->rowCount();
    }
    return -1;
}