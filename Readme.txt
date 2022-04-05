Развернуть проект:

1. Установить Yii в директорию taskforce:

composer create-project --prefer-dist yiisoft/yii2-app-basic taskforce

2. Загрузить проект из гита в директорию taskforce:

git clone https://github.com/htmlacademy-yii/291473-task-force-2.git

3. Загрузить зависимости:

composer install

4. Выполнить автозагрузку кастомных классов:

composer dump-autoload

5. Создать базу данных:

CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8mb4;

6. Получить структуру базы данных:

yii migrate

7. Загрузить тестовые данные:

yii fixture "Categories, Cities, Opinions, Profiles, Replies, Specializations, Tasks, Users"


Дополнительно:

1. Генерация тестовых данных:

php yii fixture/generate categories --count=10
php yii fixture/generate cities --count=10
php yii fixture/generate opinions --count=50
php yii fixture/generate profiles --count=10
php yii fixture/generate replies --count=10
php yii fixture/generate specializations --count=50
php yii fixture/generate tasks --count=5
php yii fixture/generate users --count=10

