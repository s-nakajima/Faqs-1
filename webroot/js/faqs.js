/*
* 発生箇所 : プレビューを閉じる。
* 編集 閉じる 編集 --- で発生。
*
* */

NetCommonsApp.controller('Faqs',
    function($scope , $http, $sce, $timeout) {

      var GET_FORM_URL = '/faqs/faqs/';
      $scope.frameId = 0;
      $scope.answerIndex = {};

      $scope.visibleContainer = true;
      $scope.visibleHeaderBtn = true;
      $scope.visibleAddFaq = false;

      $scope.htmlManage = '';
      $scope.visibleManage = false;

      $scope.modalTitle = 'FAQ追加';

      $scope.htmlEdit = '';
      $scope.visibleEdit = false;

      $scope.htmlAddFaq = '';
      $scope.visibleAddFaq = true;

      $scope.Form = {
        'question': '',
        'answer': ''
      };

      $scope.initialize = function(frameId) {
        //$scope.initialize = function(frameId) {
        $scope.frameId = frameId;

        for (var i = 1; i < 10; i++) {
          $scope.answerIndex[i] = false;
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
        $('#nc-faqs-manage-modal-' + $scope.frameId).modal('show');
//        $scope.visibleHeaderBtn = true;
//        $scope.visibleContainer = false;
//        $scope.visibleEdit = false;
//        $scope.visibleManage = true;
//        $scope.visibleAddFaq = false;
//        $scope.visibleAddFaqForm = false;
      };

      $scope.postDisplayStyle = function() {
        $scope.showContainer();
      };

      $scope.showAddFaq = function() {
        $scope.Form.question = '';
        $scope.Form.answer = '';
        $('#nc-faqs-add-link-modal-' + $scope.frameId).modal('show');
        $scope.modalTitle = 'FAQ追加';

//        $scope.visibleContainer = false;
//        $scope.visibleEdit = false;
//        $scope.visibleManage = false;
//        $scope.visibleAddFaq = false;
//
//        $scope.visibleAddFaqForm = true;
//        $scope.visibleHeaderBtn = false;
      };

      $scope.showEditFaq = function(modal, question, answer) {
        $scope.Form.question = question;
        $scope.Form.answer = answer;
        $scope.modalTitle = 'FAQ編集';
        if (modal) {
          $('#nc-faqs-add-link-modal-' + $scope.frameId).modal('show');
        } else {
          $scope.visibleAddLinkForm2 = true;
        }
      };

      $scope.deleteEditFaq = function() {
        return confirm('FAQを削除してもよろしいですか？');
      };

      $scope.deleteEditCategory = function() {
        return confirm('カテゴリーを削除してもよろしいですか？');
      };

      $scope.closeEditFaq = function() {
        $scope.visibleAddLinkForm2 = false;
        $scope.Form.question = '';
        $scope.Form.answer = '';
      };

      $scope.showAddCategory = function() {
        //$('#nc-faqs-add-link-modal-' + $scope.frameId).dismiss();
//        $('#nc-faqs-add-category-modal-' + $scope.frameId).modal('show');
      };

      $scope.changeAnswer = function(index) {
        if ($scope.answerIndex[index]) {
          $scope.closeAnswer(index);
        } else {
          $scope.openAnswer(index);
        }
      };

      $scope.openAnswer = function(index) {
        $scope.answerIndex[index] = true;
      };

      $scope.closeAnswer = function(index) {
        $scope.answerIndex[index] = false;
      };


    });
