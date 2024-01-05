# Refactoring Kata Test

## 1 - Understand the code
We create Templates with subjects and contents, and we use the TemplateManager
to compute those templates (replace placeholders with real data where needed).
Placeholders can relate to a given quote or a user.
User and Quote are passed to TemplateManager through a parameter.
If a user is not provided it will fetch the connected User through the ApplicationContext.

## 2 - Protect the code with tests
I chose to cover the code with approval testing.
It is specially recommended for this type of situation when we want to be sure not to introduce
behavioral changes while refactoring procedural legacy code which is not tested enough.
Those tests are to be thrown away once the refactoring is done.
(I had to use a fork branch of the official library because it was not compatible with PHP5.6)
Once the code to refactor is covered enough we save the snapshot, and we are good to start refactoring.

## 3 - Refactoring
### 3.1 - Upgrade PHP version and dependencies accordingly
Upgrade php version to 8.3.
Replace the deprecated "fzaninotto/faker" by "fakerphp/faker".
Upgraded phpunit and updated config accordingly.
Update the approval tests snapshots as the faker's seed did not survive the library change (I should have scrubbed these data in the first time)
### 3.2 - Introduce autoloading
Introduce autoloading thanks to composer and get rid of all the "require".
### 3.3 - Replace Singleton by DI
Remove the singleton system to introduce Dependency injection
