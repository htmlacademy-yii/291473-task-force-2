   <!-- Исполнитель. Отклик на новое задание. -->
   <?php if (
        $task->status === 'new' // Задача должна быть в статусе "Новая" (не взятая в работу);
        && $task->customer_id !== $userId // Пользователь не может быть постановщиком задачи;
        && \Yii::$app->user->identity->role === 1 // Роль пользователя должна быть - исполнитель;
        && CustomHelpers::checkExecutor($replies, $userId) // Проверяю, что пользователь еще не откликнулся на задание;
    ) : ?>
       <?php Modal::begin([
            'title' => '<h2>Отправка отклика</h2>',
            'toggleButton' => [
                'label' => 'Откликнуться на задание',
                'tag' => 'button',
                'class' => 'button button--blue',
            ],
            'footer' => $task->name,
        ]);
        ?>
       <?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>
       <?= $form->field($repliesModel, 'description')->textarea(['autofocus' => true]) ?>
       <?= $form->field($repliesModel, 'rate')->input('number') ?>
       <div class="form-group">
           <!-- <button type="submit" class="modal-button">Отправить</button> -->
           <button type="submit" class="modal-button" form="modal-form" name="reply" value="reply">Отправить</button>
           <button type="button" class="modal-button" data-dismiss="modal">Отменить</button>
       </div>
       <?php ActiveForm::end(); ?>
       <?php Modal::end(); ?>
   <?php endif; ?>


   <!-- Исполнитель. Отказ от взятого в работу задания -->
   <?php if (
        $task->status === 'in_progress' // Задача должна быть в работе;
        && $task->executor_id === $userId // ID исполнителя из задачи должен быть равен ID авторизованного пользователя;
    ) : ?>
       <?php Modal::begin([
            'title' => '<h2>Подвердите отказ от задания</h2>',
            'toggleButton' => [
                'label' => 'Отказ от задания',
                'tag' => 'button',
                'class' => 'button button--blue',
            ],
            'footer' => $task->name,
        ]);
        ?>
       <?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>
       <?= $form->field($refuseFormModel, 'description')->textarea(['autofocus' => true]) ?>
       <div class="form-group">

           <button type="submit" class="modal-button" form="modal-form" name="refuse" value="refuse">Отказаться</button>
           <button type="button" class="modal-button" data-dismiss="modal">Вернуться</button>
       </div>
       <?php ActiveForm::end(); ?>
       <?php Modal::end(); ?>
   <?php endif; ?>

   <!-- Постановщик. Завершение задания -->
   <?php if (
        $task->status === 'in_progress' // Задача должна быть в работе;
        && $task->customer_id === $userId // ID исполнителя из задачи должен быть равен ID авторизованного пользователя;
    ) : ?>
       <?php Modal::begin([
            'title' => '<h2>Принять задание</h2>',
            'toggleButton' => [
                'label' => 'Завершить задание',
                'tag' => 'button',
                'class' => 'button button--blue',
            ],
            'footer' => $task->name,
        ]);
        ?>
       <?php $form = ActiveForm::begin(['id' => 'modal-form']); ?>
       <?= $form->field($finishedTaskFormModel, 'description')->textarea(['autofocus' => true]) ?>
       <?= $form->field($finishedTaskFormModel, 'rating')->input('number', ['min' => '0', 'max' => '5']) ?>
       <div class="form-group">
           <button type="submit" class="modal-button" form="modal-form" name="finished" value="finished">Завершить</button>
           <button type="button" class="modal-button" data-dismiss="modal">Вернуться</button>
       </div>
       <?php ActiveForm::end(); ?>
       <?php Modal::end(); ?>
   <?php endif; ?>

   <!-- Постановщик. Отменить задание; -->
   <?php if (
        $task->status === 'new' // Задача должна быть в статусе Новое;
        && $task->customer_id === $userId // ID исполнителя из задачи должен быть равен ID авторизованного пользователя;
    ) : ?>
       <a href="<?= '/cancel/' . $task->id ?>" class="button button--blue">Отменить задание</a>
   <?php endif; ?>