NetCommonsApp.controller('Faqs',
    function($scope, NetCommonsBase, $modalStack, FaqFactory, dialogs, $http) {

      $scope.serverValidationClear = NetCommonsBase.serverValidationClear;

      $scope.plugin = NetCommonsBase.initUrl('faqs', 'faqs');

      $scope.frameId = 0;
      $scope.manageMode = 0;
      $scope.faqSetting = {};
      $scope.categoryOptions = {};

      $scope.faqList = {};
      $scope.answerIndex = {};
      $scope.faqListTotal = 0;
      $scope.displayCategoryId = null;
      $scope.displayNumber = null;
      $scope.currentPage = FaqFactory.Const.DEFAULT_PAGE;

      $scope.faq = {};
      $scope.status = null;

      $scope.categoryList = {};
      $scope.categoryTemplate = {};

      $scope.blockRolePermission = {};

      $scope.initialize = function(
          frameId, faqList, faqListTotal, faqSetting, categoryOptions) {
        $scope.frameId = frameId;
        $scope.faqSetting = faqSetting;
        $scope.categoryOptions = categoryOptions;
        $scope.faqList = faqList;
        $scope.faqListTotal = faqListTotal;
        $scope.displayCategoryId = faqSetting.FaqFrameSetting.display_category;
        $scope.displayNumber = faqSetting.FaqFrameSetting.display_number;
      };

      $scope.setLatestFaqList = function(results) {
        $scope.faqList = results.faqList;
        $scope.faqListTotal = results.faqListTotal;
        $scope.displayCategoryId = results.displayCategoryId;
        $scope.displayNumber = results.displayNumber;
        $scope.currentPage = results.currentPage;
        $scope.categoryOptions = results.categoryOptions;
      };

      $scope.setLatestFaq = function(results) {
        $scope.faq = results.faq;
        $scope.displayCategoryId = results.displayCategoryId;
        $scope.categoryOptions = results.categoryOptions;
        $scope.status = results.faq.Faq.status;
      };

      $scope.setLatestCategory = function(results) {
        $scope.categoryList = results.categoryList;
        $scope.categoryTemplate = results.categoryTemplate;
        $scope.categoryOptions = results.categoryOptions;
        $scope.faqList = results.faqList;
        $scope.displayCategoryId =
            results.faqSetting.FaqFrameSetting.display_category;
        $scope.displayNumber =
            results.faqSetting.FaqFrameSetting.display_number;
      };

      $scope.setLatestFrameSetting = function(results) {
        $scope.faqSetting = results.faqSetting;
        $scope.categoryOptions = results.categoryOptions;
        $scope.faqList = results.faqList;
        $scope.faqListTotal = results.faqListTotal;
        $scope.displayCategoryId = results.displayCategoryId;
        $scope.displayNumber = results.displayNumber;
        $scope.currentPage = FaqFactory.Const.DEFAULT_PAGE;
      };

      $scope.setLatestAuthoritySetting = function(results) {
        $scope.blockRolePermission = results.blockRolePermission;
      };

      $scope.switchAnswerDisplay = function(index) {
        $scope.answerIndex[index] = !$scope.answerIndex[index];
      };

      $scope.deleteFaq = function(faqId) {
        dlg = dialogs.confirm('Confirm', FaqFactory.Const.MSG_DELETE_FAQ);
        dlg.result.then(function(btn) {
          $scope.plugin.setController('faqs');
          $http.delete($scope.plugin.getUrl('delete',
              [$scope.frameId, faqId + '.json']))
            .success(function(data) {
                $scope.flash.success(data.name);
                $scope.currentPage = FaqFactory.Const.DEFAULT_PAGE;
                $scope.setLatestFaqList(data.results);
              })
            .error(function(data, status) {});
        },function(btn) {});
      };

      $scope.showFaqView = function(faqId) {
        $scope.plugin.setController('faqs');
        NetCommonsBase.showSetting(
            $scope.plugin.getUrl('edit', [$scope.frameId, faqId + '.json']),
            $scope.setLatestFaq,
            { scope: $scope,
              templateUrl: $scope.plugin.getUrl('view',
                  [$scope.frameId, $scope.manageMode]),
              controller: 'Faqs.Edit'}
        );
      };

      $scope.showSetting = function(controller) {
        $scope.plugin.setController(controller);
        options = FaqFactory.getShowSettingOptions(controller, $scope);
        NetCommonsBase.showSetting(
            options['editUrl'],
            options['callback'],
            { scope: $scope,
              templateUrl: options['url'],
              controller: options['controller']}
        );
        $scope.manageMode = 1;
      };

      $scope.cancel = function() {
        $scope.plugin.setController('faqs');
        $http.get($scope.plugin.getUrl('indexLatest', $scope.frameId + '.json'))
          .success(function(data) {
              $scope.manageMode = 0;
              $scope.setLatestFaqList(data.results);
              $modalStack.dismissAll('canceled');
            });
      };

    });


/**
 * Faqs.Edit Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, modalStack)} Controller
 */
NetCommonsApp.controller('Faqs.Edit',
    function($scope, NetCommonsBase, dialogs, $modalStack, FaqFactory, $http) {

      $scope.faqParams = {_method: 'POST', data: {}};
      $scope.faqOrderParams = {_method: 'POST', data: {}};
      $scope.faqForm = {};

      $scope.faqInitialize = function(faqForm) {
        $scope.faqForm = faqForm;
      };

      $scope.changeFaqList = function(page) {
        $scope.$parent.currentPage =
            angular.isDefined(page) ? page : FaqFactory.Const.DEFAULT_PAGE;
        $scope.plugin.setController('faqs');
        $http.get($scope.plugin.getUrl('changeView', [
          $scope.frameId,
          $scope.$parent.displayCategoryId,
          $scope.$parent.displayNumber,
          $scope.$parent.currentPage,
          Math.random() + '.json']))
          .success(function(data) {
              $scope.setLatestFaqList(data.results);
            });
      };

      $scope.publishFaq = function(faq) {
        dlg = dialogs.confirm('Confirm', FaqFactory.Const.MSG_PUBLISH_FAQ);
        dlg.result.then(function(btn) {
          $scope.faqInitialize(faq);
          $scope.saveFaq(NetCommonsBase.STATUS_PUBLISHED);
        },function(btn) {});
      };

      $scope.saveFaq = function(status) {
        $scope.plugin.setController('faqs');
        $scope.faqParams.data = {
          Faq: {
            id: $scope.faq.Faq.id,
            faq_category_id: $scope.faq.Faq.faq_category_id,
            status: $scope.faq.Faq.status,
            question: $scope.faq.Faq.question,
            answer: $scope.faq.Faq.answer
          },
          _Token: {key: '', fields: '', unlocked: ''}
        };
        $scope.faqParams.data.Faq.status = status;
        NetCommonsBase.save(
            $scope,
            $scope.faqForm,
            $scope.plugin.getUrl('token', $scope.frameId + '.json'),
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.faqParams,
            function(data) {
              $scope.flash.success(data.name);
              $modalStack.dismissAll('saved');
              $scope.setLatestFaqList(data.results);
              if ($scope.manageMode) {
                $scope.showSetting('faqs');
              }
            });
      };

      $scope.changeFaqOrder = function(changeType, index) {
        var destinationIndex = (changeType === 'up') ? index - 1 : index + 1;

        $scope.faqOrderParams.data = {
          FaqOrder: {
            type: changeType,
            destinationWeight: $scope.faqList[destinationIndex].FaqOrder.weight,
            target: {
              faq_key: $scope.faqList[index].FaqOrder.faq_key,
              weight: $scope.faqList[index].FaqOrder.weight
            }
          },
          _Token: {key: '', fields: '', unlocked: ''}
        };

        $scope.plugin.setController('faq_orders');
        NetCommonsBase.save(
            $scope,
            false,
            $scope.plugin.getUrl('token', $scope.frameId + '.json'),
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.faqOrderParams,
            function(data) {
              $scope.flash.success(data.name);
              angular.copy(data.results.faqList, $scope.faqList);
            });
      };

    });


/**
 * Faqs.category Javascript
 *
 * @param {string} Controller name
 * @param {function(scope, http, modalStack)} Controller
 */
NetCommonsApp.controller('Faqs.Category',
    function($scope, NetCommonsBase, dialogs, FaqFactory, $http) {

      $scope.faqCategoryForm = {};
      $scope.faqCategoryParams = {_method: 'POST', data: {}};
      $scope.faqCategoryOrderParams = {_method: 'POST', data: {}};

      $scope.categoryInitialize = function(index, faqCategoryForm) {
        $scope.faqCategoryForm[index] = faqCategoryForm;
      };

      $scope.deleteCategory = function(faqCategoryId, index) {
        dlg = dialogs.confirm('Confirm', FaqFactory.Const.MSG_DELETE_CATEGORY);
        dlg.result.then(function(btn) {
          $scope.plugin.setController('faq_categories');
          $http.delete($scope.plugin.getUrl('delete',
              [$scope.frameId, faqCategoryId + '.json']))
            .success(function(data) {
                $scope.flash.success(data.name);
                $scope.setLatestCategory(data.results);
                delete $scope.faqCategoryForm[
                    Object.keys($scope.faqCategoryForm).length - 2];
                $scope.clearAllValidationCategory($scope.faqCategoryForm);
              });
        },function(btn) {});
      };

      $scope.saveCategory = function(index) {
        var category = angular.isDefined(index) ?
            $scope.categoryList[index] : $scope.categoryTemplate;
        $scope.faqCategoryParams.data = {
          FaqCategory: {
            id: category.FaqCategory.id,
            name: category.FaqCategory.name
          },
          _Token: {key: '', fields: '', unlocked: ''}
        };

        $scope.plugin.setController('faq_categories');
        NetCommonsBase.save(
            $scope,
            $scope.faqCategoryForm[index],
            $scope.plugin.getUrl('token', $scope.frameId + '.json'),
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.faqCategoryParams,
            function(data) {
              $scope.flash.success(data.name);
              $scope.setLatestCategory(data.results);
              $scope.clearAllValidationCategory($scope.faqCategoryForm);
            });
      };

      $scope.changeCategoryOrder = function(changeType, index) {
        $scope.faqCategoryOrderParams.data = {
          FaqCategoryOrder: {
            type: changeType,
            faq_category_key: $scope.categoryList[index].FaqCategory.key,
            weight: $scope.categoryList[index].FaqCategoryOrder.weight
          },
          _Token: {key: '', fields: '', unlocked: ''}
        };

        $scope.plugin.setController('faq_category_orders');
        NetCommonsBase.save(
            $scope,
            false,
            $scope.plugin.getUrl('token', $scope.frameId + '.json'),
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.faqCategoryOrderParams,
            function(data) {
              $scope.flash.success(data.name);
              $scope.setLatestCategory(data.results);
              $scope.clearAllValidationCategory($scope.faqCategoryForm);
            });
      };

      $scope.clearAllValidationCategory = function(faqCategoryForm) {
        angular.forEach(faqCategoryForm, function(value, index) {
          $scope.serverValidationClear(value, 'name');
        });
      };

    });


/**
 * Faqs.FrameSetting Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsBase, $modalStack)} Controller
 */
NetCommonsApp.controller('Faqs.FrameSetting',
    function($scope, NetCommonsBase, $modalStack) {

      $scope.displaySelectedCategory = false;
      $scope.faqDisplayParams = {_method: 'POST', data: {}};

      $scope.displayChangeInitialize = function(faqSetting) {
        // 表示カテゴリの設定有無
        $scope.displaySelectedCategory =
            (faqSetting.FaqFrameSetting.display_category !== '0');

        $scope.faqDisplayParams.data = {
          FaqFrameSetting: {
            id: faqSetting.FaqFrameSetting.id,
            display_category: faqSetting.FaqFrameSetting.display_category,
            display_number: faqSetting.FaqFrameSetting.display_number
          },
          _Token: {key: '', fields: '', unlocked: ''}
        };
      };

      $scope.changeDisplaySelectedCategory = function() {
        // 選択カテゴリ表示を切り替える
        $scope.displaySelectedCategory = !$scope.displaySelectedCategory;
        // 選択カテゴリ表示しない場合、表示カテゴリを初期化する
        if ($scope.displaySelectedCategory === false) {
          $scope.faqDisplayParams.data.FaqFrameSetting.display_category = 0;
        }
      };

      $scope.saveFrameSetting = function() {
        NetCommonsBase.save(
            $scope,
            false,
            $scope.plugin.getUrl('token', $scope.frameId + '.json'),
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.faqDisplayParams,
            function(data) {
              $scope.flash.success(data.name);
              $modalStack.dismissAll('saved');
              $scope.setLatestFrameSetting(data.results);
              $scope.$parent.manageMode = 0;
            });
      };
    });


/**
 * Faqs.AuthoritySetting Javascript
 *
 * @param {string} Controller name
 * @param {function($scope, NetCommonsBase, $modalStack)} Controller
 */
NetCommonsApp.controller('Faqs.AuthoritySetting',
    function($scope, NetCommonsBase, $modalStack) {

      $scope.faqAuthorityParams = {_method: 'POST', data: {}};

      $scope.saveAuthority = function() {
        $scope.faqAuthorityParams.data = {
          BlockRolePermission: {
            id: $scope.blockRolePermission.BlockRolePermission.id,
            value:
                ($scope.blockRolePermission.BlockRolePermission.value ? 1 : 0)
          },
          _Token: {key: '', fields: '', unlocked: ''}
        };

        $scope.plugin.setController('faq_authority_settings');
        NetCommonsBase.save(
            $scope,
            false,
            $scope.plugin.getUrl('token', $scope.frameId + '.json'),
            $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
            $scope.faqAuthorityParams,
            function(data) {
              $scope.flash.success(data.name);
              $scope.setLatestAuthoritySetting(data.results);
            });
      };

    });

