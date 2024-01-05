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

## 3 - Refactoring the project
### 3.1 - Upgrade PHP version and dependencies accordingly
Upgrade php version to 8.3.
Replace the deprecated "fzaninotto/faker" by "fakerphp/faker".
Upgraded phpunit and updated config accordingly.
Update the approval tests snapshots as the faker's seed did not survive the library change (I should have scrubbed these data in the first time)
### 3.2 - Introduce autoloading
Introduce autoloading thanks to composer and get rid of all the "require".
### 3.3 - Replace Singleton by DI
Remove the singleton system to introduce Dependency injection
### 3.4 - Introduce Service Container
Introduce Service Container (and autowiring) thanks to "symfony/dependency-injection"
### 3.5 - Correct POO encapsulation
Update code to respect POO encapsulation principle thanks to readonly classes

## 4 - Refactoring TemplateManager
### 4.1 - Algorithmic improvements
Update the algorithmic using up-to-date code (new features provided by PHP earlier versions).
Simplify the logic and improve the readability.
### 4.2 - Enriching the domain
I tried to follow the sandwich pattern technique to refactor the service.
It implies to put the shared states on the extremities of the method to highlight the immutable domain (the domain logic)
and finally try to enrich our domain (Aggregates, Entities, ValueObjects and if needed Domain services).
In that end I created a TemplatedText ValueObject to encapsulate the logic (contains and replace).
