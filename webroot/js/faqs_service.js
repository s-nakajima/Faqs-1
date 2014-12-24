NetCommonsApp.factory('FaqFactory', function($http, NetCommonsBase) {
  return {
    Const: {
      'MSG_PUBLISH_FAQ' : 'FAQを公開してもよろしいですか？',
      'MSG_DELETE_FAQ' : 'FAQを削除してもよろしいですか？',
      'MSG_DELETE_CATEGORY' : 'カテゴリを削除してもよろしいですか？',
      'DEFAULT_FAQ_ID' : 0,
      'DEFAULT_FAQ_CATEGORY_ID' : 0,
      'DEFAULT_PAGE' : 1
    },

    getShowSettingOptions: function(controller, $scope) {
      var options = [];
      options['editUrl'] =
          $scope.plugin.getUrl('edit', $scope.frameId + '.json'),
      options['url'] = $scope.plugin.getUrl('view', $scope.frameId);
      switch (controller) {
        case 'faqs':
          options['editUrl'] =
              $scope.plugin.getUrl('indexLatest', $scope.frameId + '.json');
          options['url'] = $scope.plugin.getUrl('indexSetting', $scope.frameId);
          options['controller'] = 'Faqs.Edit';
          options['callback'] = $scope.setLatestFaqList;
          break;
        case 'faq_categories':
          options['controller'] = 'Faqs.Category';
          options['callback'] = $scope.setLatestCategory;
          break;
        case 'faq_frame_settings':
          options['controller'] = 'Faqs.FrameSetting';
          options['callback'] = $scope.setLatestFrameSetting;
          break;
        case 'faq_authority_settings':
          options['controller'] = 'Faqs.AuthoritySetting';
          options['callback'] = $scope.setLatestAuthoritySetting;
          break;
      }
      return options;
    }

  };

});
