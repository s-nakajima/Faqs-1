/*
* 発生箇所 : プレビューを閉じる。
* 編集 閉じる 編集 --- で発生。
*
* */

//NetCommonsApp.requires.push('dialogs.main');
NetCommonsApp
  .controller('Faqs',
    function($scope , $http, $sce, $timeout) {
//    function($scope , $http, dialogs) {

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
//        dlg = $dialogs.create('/dialogs/whatsyourname.html','whatsYourNameCtrl',{},{key: false,back: 'static'});
//        dlg.result.then(function(name){
//          $scope.name = name;
//        },function(){
//          $scope.name = 'You decided not to enter in your name, that makes me sad.';
//        });


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
        var message = 'FAQを削除してもよろしいですか？';

//        dialogs.confirm(undefined, message)
//          .result.then(
//            function(yes) {
//              //alert('yes');
//              return true;
////              $http.delete('/frames/frames/' + frameId.toString())
////                .success(function(data, status, headers, config) {
////                    $scope.deleted = true;
////                  })
////                .error(function(data, status, headers, config) {
////                    alert(status);  // It should be error code
////                    return false;
////                  });
//            },
//            function(no) {
//              //alert('no');
//              return false;
//            });

        return confirm(message);
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
//  .controller('whatsYourNameCtrl',function($scope, $modalInstance, data){
//    $scope.user = {name : ''};
//
//    $scope.cancel = function(){
//      $modalInstance.dismiss('canceled');
//    }; // end cancel
//
//    $scope.save = function(){
//      $modalInstance.close($scope.user.name);
//    }; // end save
//
//    $scope.hitEnter = function(evt){
//      if(angular.equals(evt.keyCode,13) && !(angular.equals($scope.name,null) || angular.equals($scope.name,'')))
//          $scope.save();
//    }; // end hitEnter
//  }) // end whatsYourNameCtrl
//  .run(['$templateCache',function($templateCache){
//    $templateCache.put('/dialogs/whatsyourname.html','<div class="modal"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h4 class="modal-title"><span class="glyphicon glyphicon-star"></span> User\'s Name</h4></div><div class="modal-body"><ng-form name="nameDialog" novalidate role="form"><div class="form-group input-group-lg" ng-class="{true: \'has-error\'}[nameDialog.username.$dirty && nameDialog.username.$invalid]"><label class="control-label" for="username">Name:</label><input type="text" class="form-control" name="username" id="username" ng-model="user.name" ng-keyup="hitEnter($event)" required><span class="help-block">Enter your full name, first &amp; last.</span></div></ng-form></div><div class="modal-footer"><button type="button" class="btn btn-default" ng-click="cancel()">Cancel</button><button type="button" class="btn btn-primary" ng-click="save()" ng-disabled="(nameDialog.$dirty && nameDialog.$invalid) || nameDialog.$pristine">Save</button></div></div></div></div>');
//  }]); // end run / module
