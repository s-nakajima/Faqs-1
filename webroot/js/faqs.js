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
      $scope.manageMode = 0;
      $scope.faqList = {};
      $scope.categoryOptions = {};
      $scope.faq = {};
      $scope.selectedCategory = null;

      $scope.initFaq = function(frameId, categoryOptions, categoryId) {
        $scope.frameId = frameId;
        $scope.categoryOptions = categoryOptions;

        if (categoryId) {
          angular.forEach(categoryOptions, function(opt) {
            if (categoryId == opt.category.id) {
              $scope.selectedCategory = opt;
            }
          });
        }
      };

      $scope.initFaqEdit = function(data) {
        $scope.frameId = data.frameId;
        $scope.faqList = data.faqList;
        $scope.categoryOptions = data.categoryOptions;
        $scope.faq = data.faq;

        if (data.faq.faq.categoryId) {
          angular.forEach(data.categoryOptions, function(opt) {
            if (data.faq.faq.categoryId == opt.category.id) {
              $scope.selectedCategory = opt;
            }
          });
        }
      };

      $scope.initFaqOrder = function(data) {
        $scope.frameId = data.frameId;
        $scope.faqList = data.faqList;
      };

      $scope.selectCategory = function() {
        var url = '/faqs/faqs/index/' + $scope.frameId;
        if ($scope.selectedCategory) {
          url += '/' + $scope.selectedCategory.category.id;
        }
        $window.location.href = url;
      };

      $scope.sortFaq = function(moveType, index) {
        var destIndex = (moveType === 'up') ? index - 1 : index + 1;
        if (angular.isUndefined($scope.faqList[destIndex])) {
          return false;
        }

        var destCategory = angular.copy($scope.faqList[destIndex]);
        var targetCategory = angular.copy($scope.faqList[index]);
        $scope.faqList[index] = destCategory;
        $scope.faqList[destIndex] = targetCategory;
      };
    });
