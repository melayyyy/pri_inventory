<?php
require_once '../init.php';

if (isset($_POST)) {
    $expense_catName = $_POST['expense_catName'];
    $expesecatDescrip = $_POST['expesecatDescrip'];

    if (!empty($expense_catName)) {
        // Gagamit lang tayo ng 'name' at 'description'
        $query = array(
            'name'        => $expense_catName,
            'description' => $expesecatDescrip
        );

        // Subukan natin ang 'expense_catagory' (may a)
        $res = $obj->create('expense_catagory', $query);

        if ($res) {
            echo "yes";
        } else {
            // Kung ayaw pa rin, subukan nating i-change ang 'expense_catagory' 
            // sa baba gawing 'expense_category' (may e)
            $res2 = $obj->create('expense_category', $query);
            
            if($res2) {
                echo "yes";
            } else {
                echo "SQL Error: Check if column names are correct (name, description)";
            }
        }
    } else {
        echo "Purpose name is required";
    }
}
?>
