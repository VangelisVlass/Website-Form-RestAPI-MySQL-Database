<?php
class UserController extends BaseController
{
    /**
     * "/user/list" Endpoint - Get list of users
     */
    public function listAction()
    {
        $strErrorDesc = '';
        $requestMethod = $_SERVER["REQUEST_METHOD"];
        // $arrQueryStringParams = $this->getQueryStringParams();

        if (strtoupper($requestMethod) == 'GET') {
            try {
                $userModel = new UserModel();


                $arrUsers = $userModel->getUsers();
                $responseData = json_encode($arrUsers);
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else if (strtoupper($requestMethod) == 'POST') {
            try {
                $json = file_get_contents('php://input');
                $data = json_decode($json);
                $userModel = new UserModel();

                $first_name =  $data->firstname;
                $last_name = $data->lastname;
                $email =  $data->email;
                $mobile = $data->mobile;
                $category = $data->category;
                $userModel->insertUser($first_name, $last_name, $email, $mobile, $category);
                $responseData = json_encode(array('user created'));
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else if (strtoupper($requestMethod) == 'DELETE') {
            try {
                $userModel = new UserModel();

                $id = $_REQUEST['id'];
                $userModel->deleteUser($id);
                $responseData = json_encode(array('user deleted with id' => $id));
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else if (strtoupper($requestMethod) == 'PUT') {
            try {
                $json = file_get_contents('php://input');
                $data = json_decode($json);
                $userModel = new UserModel();

                $id = $data->id;
                $first_name =  $data->firstname;
                $last_name = $data->lastname;
                $email =  $data->email;
                $mobile = $data->mobile;
                $category = $data->category;
                $userModel->updateUser($id, $first_name, $last_name, $email, $mobile, $category);
                $responseData = json_encode(array('user edited', $id));
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage() . 'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        } else {
            $strErrorDesc = 'Method not supported';
            $strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(
                json_encode(array('error' => $strErrorDesc)),
                array('Content-Type: application/json', $strErrorDesc)
            );
        }
    }
}
