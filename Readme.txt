Развернуть проект:

1. Установить Yii в директорию taskforce:

composer create-project --prefer-dist yiisoft/yii2-app-basic taskforce

2. Выполнить автозагрузку кастомных классов:

composer dump-autoload

3. Создать базу данных:

CREATE DATABASE taskforce
  DEFAULT CHARACTER SET utf8mb4;

4. Получить структуру базы данных:

yii migrate

5. Загрузить тестовые данные:

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

