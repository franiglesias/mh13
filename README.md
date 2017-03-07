# mh13

Its a provisional repository to repair legacy code for a school website and intranet.

It's written in CakePHP 1.3.

Steps in refactoring:

1. Migrate the View (V from MVC) to Twig, removing all legacy view code. (in progress)
2. Extract domain/business code from controller and leave them as flat as a sheet of paper (well, you get the idea). We could need temporary obese models.
3. Refactor the model layer to obtain real separation of concerns:
    * Domain logic nicely isolated
    * Database moved to infrastructure layer
    * Use case / Command / Event architecture to move data between the domain an the controllers

May the rigor be with you.
