<?php
class Home extends Controller{
  protected function index(){
    $viewmodel = new HomeModel();
    $this->returnView($viewmodel->index(),true);
  }
  protected function editProfile(){
    $viewmodeL = new HomeModel();
    $viewmodeL->editProfile();
  }
}
?>
