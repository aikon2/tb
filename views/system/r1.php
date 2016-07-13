<?php
/**
 * @var yii\web\View            $this
 * @var kartik\tree\models\Tree $node
 */
use yii\widgets\Pjax;
use yii\web\JsExpression;
use execut\widget\TreeView;
use yii\helpers\Url;
use app\models\system\Tree;
use yii\helpers\Html;
Pjax::begin([
    'id' => 'pjax-container',
]);

echo \yii::$app->request->get('page');

Pjax::end();

$onSelect = new JsExpression(<<<JS
function (undefined, item) {
    if (item.href !== location.pathname) {
        $.pjax({
            container: '#pjax-container',
            url: item.href,
            timeout: null
        });
    }

    var otherTreeWidgetEl = $('.treeview.small').not($(this)),
        otherTreeWidget = otherTreeWidgetEl.data('treeview'),
        selectedEl = otherTreeWidgetEl.find('.node-selected');
    if (selectedEl.length) {
        otherTreeWidget.unselectNode(Number(selectedEl.attr('data-nodeid')));
    }
}
JS
);

$items = [
    [
        'text' => 'Parent 1',
        'href' => Url::to(['', 'page' => 'parent1']),
        'nodes' => [
            [
                'text' => 'Child 1',
                'href' => Url::to(['', 'page' => 'child1']),
                'nodes' => [
                    [
                        'text' => 'Grandchild 1',
                        'href' => Url::to(['', 'page' => 'grandchild1'])
                    ],
                    [
                        'text' => 'Grandchild 2',
                        'href' => Url::to(['', 'page' => 'grandchild2'])
                    ]
                ]
            ],
        ],
    ],
];

echo TreeView::widget([
    'data' => $items,
    'size' => TreeView::SIZE_SMALL,
    'clientOptions' => [
        'onNodeSelected' => $onSelect,
    ],
]);

$users = Tree::find()
        //->where(['root' => 5])
        ->orderBy('root','lft')
        ->all(); 
$level = 0;
foreach ($users as $n => $user)
        {
            if (!$user->lvl) {
                echo Html::beginTag('ul') . PHP_EOL;
            }

            if ($user->lvl && $user->lvl == $level) {
                echo Html::endTag('li') . PHP_EOL;
            } elseif ($user->lvl > $level) {
                echo PHP_EOL . Html::beginTag('ul') . PHP_EOL;
            } else {
                if ($user->lvl) {
                    echo Html::endTag('li' . $user->lvl) . PHP_EOL;
                }
                for ($i = $level - $user->lvl; $i; $i--) {
                    echo Html::endTag('ul') . PHP_EOL;
                    echo Html::endTag('li') . PHP_EOL;
                }
            }

            echo Html::beginTag('li');
            echo Html::encode($user->name);
            $level = $user->lvl;
        }

        for ($i = $level; $i; $i--) {
            echo Html::endTag('li') . PHP_EOL;
            echo Html::endTag('ul') . PHP_EOL;
        }