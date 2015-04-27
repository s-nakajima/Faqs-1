/**
 * @fileoverview Faqs Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * FaqIndex Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('FaqIndex', function($scope) {
  /**
   * Switching display of answer
   *
   * @return {void}
   */
  $scope.displayAnswer = function(id) {
    var element = $(id);
    if (element.hasClass('hidden')) {
      element.removeClass('hidden');
    } else {
      element.addClass('hidden');
    }
  };

});


/**
 * FaqQuestion Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsWysiwyg)} Controller
 */
NetCommonsApp.controller('FaqQuestions', function($scope, NetCommonsWysiwyg) {

  /**
   * tinymce
   *
   * @type {object}
   */
  $scope.tinymce = NetCommonsWysiwyg.new();

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    $scope.faqQuestion = data.faqQuestion;
  };
});


/**
 * FaqQuestionOrders Javascript
 *
 * @param {string} Controller name
 * @param {function($scope)} Controller
 */
NetCommonsApp.controller('FaqQuestionOrders', function($scope) {

  /**
   * FaqQuestions
   *
   * @type {object}
   */
  $scope.faqQuestions = [];

  /**
   * initialize
   *
   * @return {void}
   */
  $scope.initialize = function(data) {
    $scope.faqQuestions = data.faqQuestions;
  };

  /**
   * move
   *
   * @return {void}
   */
  $scope.move = function(type, index) {
    var dest = (type === 'up') ? index - 1 : index + 1;
    if (angular.isUndefined($scope.faqQuestions[dest])) {
      return false;
    }

    var destQuestion = angular.copy($scope.faqQuestions[dest]);
    var targetQuestion = angular.copy($scope.faqQuestions[index]);
    $scope.faqQuestions[index] = destQuestion;
    $scope.faqQuestions[dest] = targetQuestion;
  };

});


//NetCommonsApp.controller('Faqs',
//    function($scope, NetCommonsBase, NetCommonsWysiwyg,
//    NetCommonsTab, NetCommonsUser, NetCommonsWorkflow, $window, $http) {
//
//      /**
//       * tab
//       *
//       * @type {object}
//       */
//      $scope.tab = NetCommonsTab.new();
//
//      /**
//       * show user information method
//       *
//       * @param {number} users.id
//       * @return {string}
//       */
//      $scope.user = NetCommonsUser.new();
//
//      /**
//       * tinymce
//       *
//       * @type {object}
//       */
//      $scope.tinymce = NetCommonsWysiwyg.new();
//
//      /**
//       * workflow
//       *
//       * @type {object}
//       */
//      $scope.workflow = NetCommonsWorkflow.new($scope);
//
//      $scope.plugin = NetCommonsBase.initUrl('faqs', 'faqs');
//
//      $scope.frameId = 0;
//      $scope.faqs = {};
//      $scope.faq = {};
//      $scope.selectedCategoryId = 0;
//
//      $scope.initFaq = function(frameId, categoryId) {
//        $scope.frameId = frameId;
//        $scope.selectedCategoryId = categoryId;
//      };
//
//      $scope.initFaqEdit = function(frameId, faq) {
//        $scope.frameId = frameId;
//        $scope.faq = faq;
//        var categoryId = faq.faq.categoryId;
//        if (angular.isDefined(categoryId)) {
//          $scope.selectedCategoryId = categoryId;
//        }
//      };
//
//      $scope.initFaqOrder = function(frameId, faqs) {
//        $scope.frameId = frameId;
//        $scope.faqs = faqs;
//      };
//
//      $scope.selectCategory = function() {
//        var url = '/faqs/faqs/index/' + $scope.frameId;
//        if ($scope.selectedCategoryId) {
//          url += '/' + $scope.selectedCategoryId;
//        }
//        $window.location.href = url;
//      };
//
//      $scope.sortFaq = function(moveType, index) {
//        var destIndex = (moveType === 'up') ? index - 1 : index + 1;
//        if (angular.isUndefined($scope.faqs[destIndex])) {
//          return false;
//        }
//
//        var destCategory = angular.copy($scope.faqs[destIndex]);
//        var targetCategory = angular.copy($scope.faqs[index]);
//        $scope.faqs[index] = destCategory;
//        $scope.faqs[destIndex] = targetCategory;
//      };
//
//      /* frame setting START */
//
//      $scope.orderByField = 'block.name';
//      $scope.isOrderDesc = false;
//
//      $scope.parseDate = function(d) {
//        rep = d.replace(/-/g, '/');
//        var date = Date.parse(rep);
//        return new Date(date);
//      };
//
//      $scope.orderBlock = function(field) {
//        $scope.isOrderDesc =
//            ($scope.orderByField === field) ? !$scope.isOrderDesc : false;
//        $scope.orderByField = field;
//      };
//
//      $scope.setBlock = function(frameId, blockId) {
//        $http.post('/faqs/blocks/setBlock/' + frameId + '/' + blockId)
//          .success(function(data, status, headers, config) {
//              $scope.flash.success(data.name);
//            })
//          .error(function(data, status, headers, config) {
//              $scope.flash.danger(data.name);
//            });
//      };
//
//      $scope.showCalendar = function($event, type) {
//        $event.stopPropagation();
//        if (type === 'from') {
//          $scope.isFrom = !$scope.isFrom;
//        } else if (type === 'to') {
//          $scope.isTo = !$scope.isTo;
//        }
//      };
//      /* frame setting E N D */
//    })
//.config(function(datepickerConfig, datepickerPopupConfig) {
//      angular.extend(datepickerConfig, {
//        formatMonth: 'yyyy / MM',
//        formatDayTitle: 'yyyy / MM',
//        showWeeks: false
//      });
//      angular.extend(datepickerPopupConfig, {
//        datepickerPopup: 'yyyy/MM/dd HH:mm',
//        showButtonBar: false
//      });
//    });
