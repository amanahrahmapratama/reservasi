<script src="<?php echo media_url('js/angular-1.0.8.min.js'); ?>"></script>
<script>
    function getCsrfToken() {
        $.getJSON("<?php echo site_url('get-csrf-token') ?>", function(data) {
            $('input[name="csrf_test_name"]').val(data.csrf_token);
        });
    }

    var myApp = angular.module('myApp', []);

    myApp.controller('categoriesCtrl', function($scope, $http) {
        $scope.categories = <?php echo $category ?>;

        <?php if (isset($posting)): ?>
            $scope.category_data = {index: <?php echo $posting['posting_category_posting_category_id']; ?>};
        <?php elseif (set_value('category_id')): ?>
            $scope.category_data = {index: <?php echo set_value('category_id'); ?>};
        <?php endif; ?>

        $scope.addCategory = function() {
            var cct = $("input[name=<?php echo $this->security->get_csrf_token_name(); ?>]").val();
            
            $http({
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                url: '<?php echo site_url('admin/posting/add_category'); ?>', data: "category_name=" + $scope.categoryText + "&<?php echo $this->security->get_csrf_token_name(); ?>=" + cct
            })
            .success(function(data, status, headers, config) {
                $scope.categories.push({
                    posting_category_name: $scope.categoryText,
                    posting_category_id: data
                });

                $scope.categoryText = '';

                setTimeout(function() {
                    $('#selectCat').find('option:last').attr('selected', 'selected');
                }, 200);

                getCsrfToken();
            })
            .error(function(data, status, headers, config) {
                // alert error
            });
        };
    })
</script>