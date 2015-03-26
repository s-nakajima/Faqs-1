NetCommonsApp.controller('Faqs',
    function($scope, NetCommonsBase, NetCommonsWysiwyg,
    NetCommonsTab, NetCommonsUser, NetCommonsWorkflow, $window, $http) {

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

      /* frame setting START */

      $scope.orderByField = 'block.name';
      $scope.isOrderDesc = false;

      $scope.parseDate = function(d) {
        rep = d.replace(/-/g, '/');
        var date = Date.parse(rep);
        return new Date(date);
      };

      $scope.orderBlock = function(field) {
        $scope.isOrderDesc =
            ($scope.orderByField === field) ? !$scope.isOrderDesc : false;
        $scope.orderByField = field;
      };

      $scope.setBlock = function(frameId, blockId) {
        $http.post('/faqs/blocks/setBlock/' + frameId + '/' + blockId)
          .success(function(data, status, headers, config) {
              $scope.flash.success(data.name);
            })
          .error(function(data, status, headers, config) {
              $scope.flash.danger(data.name);
            });
      };

      $scope.showCalendar = function($event, type) {
        $event.stopPropagation();
        if (type === 'from') {
          $scope.isFrom = !$scope.isFrom;
        } else if (type === 'to') {
          $scope.isTo = !$scope.isTo;
        }
      };
      /* frame setting E N D */
    })
.config(function(datepickerConfig, datepickerPopupConfig) {
      angular.extend(datepickerConfig, {
        formatMonth: 'yyyy / MM',
        formatDayTitle: 'yyyy / MM',
        showWeeks: false
      });
      angular.extend(datepickerPopupConfig, {
        datepickerPopup: 'yyyy/MM/dd HH:mm',
        showButtonBar: false
      });
    });
