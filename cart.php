<?php
session_start();
if(isset($_SESSION['user'])){

    require_once dirname(__FILE__).'/vendor/autoload.php';
    $translate = new classes\Languages\Translate($_COOKIE['lang']);

    include_once dirname(__FILE__).'/displayErrors.php';
    if(isset($_POST['action']) || isset($_GET['action'])){
        $action = isset($_POST['action']) ? $_POST['action'] : $_GET['action'];

        switch ($action) {
            case 'addProduct':
                if(isset($_GET['type']) && isset($_GET['id'])){
                    $cart = array();
                    $type = $_GET['type']; //4-user product, 1,2,3-admin product
                    $id = $_GET['id'];
                    if(isset($_COOKIE['cart'])){
                        $cart = unserialize(base64_decode($_COOKIE['cart']));
                        if(isset($cart[$type])){
                            array_push($cart[$type], $id);
                        }else{
                            $cart[$type][0] = $id;
                        }
                        
                        $cart = base64_encode(serialize($cart));
                        setcookie('cart', $cart, time() + (86400 * 30), "/");
                        
                    }else{
                        $cart[$type][0] = $id;
                        $cart = base64_encode(serialize($cart));
                        setcookie('cart', $cart, time() + (86400 * 30), "/");
                    }
                    header("Location: cart.php");
                }else{
                    header("Location: cart.php");
                }
                
                break;

            case 'deleteProduct':
                if(isset($_GET['id']) && isset($_GET['type']) && isset($_COOKIE['cart'])){
                    $cart = unserialize(base64_decode($_COOKIE['cart']));
                    $type = $_GET['type'];
                    if(($key = array_search($_GET['id'], $cart[$type])) !== false) {
                        unset($cart[$type][$key]);
                        if(empty($cart[$type])){
                            unset($cart[$type]);
                        }
                    }
                    $cart = base64_encode(serialize($cart));
                    setcookie('cart', $cart, time() + (86400 * 30), "/");
                    header("Location: cart.php");
                }else{
                    header("Location: cart.php");
                }
                break;

            case 'buyItemsForTokens':
                try {
                    $user = unserialize(base64_decode($_SESSION['user']));
                    $order = new \classes\Order\Order($user->getId());
                    $order->saveOrder($_POST);
                } catch (Exception $e) {
                    $_SESSION['errors'][] = $e->getMessage();
                    header("Location: cart.php");
                    exit();
                }
                $user = new \classes\User\User($user->getId());
                $_SESSION['user'] = base64_encode(serialize($user)); // update usera w sesji
                $cart = unserialize(base64_decode($_COOKIE['cart']));
                unset($cart[4]);
                $cart = base64_encode(serialize($cart));
                setcookie('cart', $cart, time() + (86400 * 30), "/");
                header("Location: order-complete.php");
                break;

            case 'buyItemsForMoney':
                try {
                    $user = unserialize(base64_decode($_SESSION['user']));
                    $order = new \classes\Order\Order($user->getId());
                    $order->saveOrder($_POST);

                    $payment = new \classes\Payment\Payment($order->getId());
                    $payment->uploadPaymentStatus();
                    //switch($_POST['payment']){
                    //    case 'paypal':
                    //        $payment = new \classes\Payment\PayPal($order);
                    //        break;
                    //}
                    $user = new \classes\User\User($user->getId());
                    $_SESSION['user'] = base64_encode(serialize($user));
                } catch (Exception $e) {
                    $_SESSION['errors'][] = $e->getMessage();
                    header("Location: cart.php");
                    exit();
                }
                $cart = unserialize(base64_decode($_COOKIE['cart']));
                if(isset($cart[1])){unset($cart[1]);}
                if(isset($cart[2])){unset($cart[2]);}
                if(isset($cart[3])){unset($cart[3]);}
                $cart = base64_encode(serialize($cart));
                setcookie('cart', $cart, time() + (86400 * 30), "/");
                header("Location: order-complete.php");
                break;
        }
    }else{
        if(isset($_COOKIE['cart'])){
            $cart = unserialize(base64_decode($_COOKIE['cart']));
            $products = array();
            $products = isset($cart[1]) ? array_merge($products, $cart[1]) : $products;
            $products = isset($cart[2]) ? array_merge($products, $cart[2]) : $products;
            $products = isset($cart[3]) ? array_merge($products, $cart[3]) : $products;
            if(!empty($products)){
                foreach($products as $k){
                    $products_admin[] = new \classes\Product\Product($k);
                }
            }
            if(!empty($cart[4])){//user products
                foreach($cart[4] as $k){
                    $products_user[] = new \classes\Product\Product($k);
                }
            }
        }
        include dirname(__FILE__).'/templates/cart.html.php';
    }
}else{
    header("Location: /home");
}
?>