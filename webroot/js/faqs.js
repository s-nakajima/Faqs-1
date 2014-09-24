/*
* 発生箇所 : プレビューを閉じる。
* 編集 閉じる 編集 --- で発生。
*
* */

NetCommonsApp.controller('Faqs',
    function($scope , $http, $sce, $timeout) {

      var GET_FORM_URL = '/faqs/faqs/';
      $scope.frameId = 0;
      $scope.answer = {};

      $scope.visibleContainer = true;
      $scope.visibleHeaderBtn = true;
      $scope.visibleAddFaq = false;

      $scope.htmlManage = '';
      $scope.visibleManage = false;

      $scope.htmlEdit = '';
      $scope.visibleEdit = false;

      $scope.htmlAddFaq = '';
      $scope.visibleAddFaq = true;

      $scope.initialize = function(frameId) {
        //$scope.initialize = function(frameId) {
        $scope.frameId = frameId;

        for (var i = 1; i < 10; i++) {
          $scope.answer[i] = false;
        }
      };

      $scope.showContainer = function() {
        $scope.visibleHeaderBtn = true;
        $scope.visibleContainer = true;
        $scope.visibleEdit = false;
        $scope.visibleManage = false;
        $scope.visibleAddFaq = true;
        $scope.visibleAddFaqForm = false;
      };

      $scope.showEdit = function() {
        $scope.visibleHeaderBtn = true;
        $scope.visibleContainer = false;
        $scope.visibleEdit = true;
        $scope.visibleManage = false;
        $scope.visibleAddFaq = true;
        $scope.visibleAddFaqForm = false;
      };

      $scope.showManage = function() {
        $scope.visibleHeaderBtn = true;
        $scope.visibleContainer = false;
        $scope.visibleEdit = false;
        $scope.visibleManage = true;
        $scope.visibleAddFaq = false;
        $scope.visibleAddFaqForm = false;
      };

      $scope.postDisplayStyle = function() {
        $scope.showContainer();
      };

      $scope.showAddFaq = function() {
        //$('#nc-faqs-add-link-modal-' + $scope.frameId).modal('show');

        $scope.visibleContainer = false;
        $scope.visibleEdit = false;
        $scope.visibleManage = false;
        $scope.visibleAddFaq = false;

        $scope.visibleAddFaqForm = true;
        $scope.visibleHeaderBtn = false;
      };

      $scope.showAddCategory = function() {
        //$('#nc-faqs-add-link-modal-' + $scope.frameId).dismiss();
        $('#nc-faqs-add-category-modal-' + $scope.frameId).modal('show');
      };

      $scope.changeAnswer = function(index) {
        if ($scope.answer[index]) {
          $scope.closeAnswer(index);
        } else {
          $scope.openAnswer(index);
        }
      };

      $scope.openAnswer = function(index) {
        $scope.answer[index] = true;
      };

      $scope.closeAnswer = function(index) {
        $scope.answer[index] = false;
      };

    });
