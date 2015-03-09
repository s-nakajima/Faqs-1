NetCommonsApp.controller('Faqs',
    function($scope, NetCommonsBase, NetCommonsWysiwyg,
    NetCommonsTab, NetCommonsUser, NetCommonsWorkflow, $http, $sce) {

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

      $scope.initFaq = function(data) {
        $scope.frameId = data.frameId;
        $scope.faqList = data.faqList;
        $scope.categoryOptions = data.categoryOptions;
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
        var params = null;
        if ($scope.selectedCategory) {
          params = [$scope.frameId,
            $scope.selectedCategory.category.id + '.json'];
        } else {
          params = [$scope.frameId + '.json'];
        }
        $scope.plugin.setController('faqs');
        $http.get($scope.plugin.getUrl('selectCategory', params))
          .success(function(results) {
              $scope.setLatestFaqList(results);
            });
      };

      $scope.setLatestFaqList = function(results) {
        $scope.faqList = results.faqList;
        $scope.categoryOptions = results.categoryOptions;
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
