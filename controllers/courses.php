<?php
class Courses extends Controller{

  protected function currentCourses(){
      $currentCoursesModel = new CourseModel();
      $this->returnView($currentCoursesModel->currentCourses(),true);
  }

  protected function showSections(){
    $showSectionsModel = new CourseModel();
    $showSectionsModel->showSections();
  }

  protected function addSection(){
    $addSectionModel = new CourseModel();
    $addSectionModel->addSection();
  }

  protected function deleteSection(){
    $deleteSectionModel= new CourseModel();
    $deleteSectionModel->deleteSection();
  }

  protected function updateSection(){
    $updateSectionModel = new CourseModel();
    $updateSectionModel->updateSection();
  }

  protected function registeredCourses(){
    $registeredCoursesModel = new CourseModel();
    $this->returnView($registeredCoursesModel->registeredCourses(),true);
  }

  protected function grades(){
    $gradesModel = new CourseModel();
    $this->returnView($gradesModel->grades(),true);
  }
}
?>
