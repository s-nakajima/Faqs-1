NetCommonsApp.controller('Faqs',
    function($scope, NetCommonsBase, NetCommonsWysiwyg,
    NetCommonsTab, NetCommonsUser, NetCommonsWorkflow, $window) {

      /**
       * tab
       *
       * @type {object}
       */
      $scope.tab = NetCommonsTab.new();

      /**
       * show user information method
       *
       * @param {number} users.id
       * @return {string}
       */
      $scope.user = NetCommonsUser.new();

      /**
       * tinymce
       *
       * @type {object}
       */
      $scope.tinymce = NetCommonsWysiwyg.new();

      /**
       * workflow
       *
       * @type {object}
       */
      $scope.workflow = NetCommonsWorkflow.new($scope);

      $scope.plugin = NetCommonsBase.initUrl('faqs', 'faqs');

      $scope.frameId = 0;
      $scope.faqs = {};
      $scope.faq = {};
      $scope.selectedCategoryId = 0;

      $scope.initFaq = function(frameId, categoryId) {
        $scope.frameId = frameId;
        $scope.selectedCategoryId = categoryId;
      };

      $scope.initFaqEdit = function(data) {
        $scope.frameId = data.frameId;
        $scope.faq = data.faq;
        var categoryId = data.faq.faq.categoryId;
        if (angular.isDefined(categoryId)) {
          $scope.selectedCategoryId = categoryId;
        }
      };

      $scope.initFaqOrder = function(data) {
        $scope.frameId = data.frameId;
        $scope.faqs = data.faqs;
      };

      $scope.selectCategory = function() {
        var url = '/faqs/faqs/index/' + $scope.frameId;
        if ($scope.selectedCategoryId) {
          url += '/' + $scope.selectedCategoryId;
        }
        $window.location.href = url;
      };

      $scope.sortFaq = function(moveType, index) {
        var destIndex = (moveType === 'up') ? index - 1 : index + 1;
        if (angular.isUndefined($scope.faqs[destIndex])) {
          return false;
        }

        var destCategory = angular.copy($scope.faqs[destIndex]);
        var targetCategory = angular.copy($scope.faqs[index]);
        $scope.faqs[index] = destCategory;
        $scope.faqs[destIndex] = targetCategory;
      };
    });
