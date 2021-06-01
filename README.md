**MadHarper Commission Task**

Call the script.php method:

_> php script.php path-to-csv-file_

For tests:

_> composer test_



there are no strict deadlines, but lets keep in touch - if you have any problems or have no free time available for the task, just contact us;
task must be made in PHP;
you must use this skeleton as a bootstrap for your task solution. Make sure that composer run test succeeds before sending the task;
third party libraries, dependencies, tools, frameworks etc. can be used if seems necessary. Avoid including framework into your task if you don't actually use it.
We would suggest to use composer for autoloading even if you do not use any external dependencies - we highly recommend using PSR-4;
your system must be maintainable:
clear dependencies between separate parts of your code;
system must be both testable and tested (unit tests are required);
code understandable, readable, have a clear flow;
your system must be extensible:
adding new functionality or changing existing one should not require rewriting the system itself or it's core parts;
code must be PSR-1 and PSR-2 compatible;
minimal documentation should be provided:
how system should be ran (what command to run);
how to initiate system's tests (what command to run);
short description of functionality in more difficult places could be provided in the code itself;
do not use external infrastructure dependencies, like MySQL databases or temporary files - just make the calculations in memory;
do not use Paysera name in titles, descriptions or the code itself. This helps others to find the libraries that are really related to our services and/or are developed and 
maintained by our team.

Task
Situation
Paysera users can go to a branch to cash in and/or cash out from Paysera account. Several currencies are supported. There are also commission fees for both cash in and cash out.

Commission Fees
For Cash In
Commission fee - 0.03% from total amount, but no more than 5.00 EUR.

For Cash Out
There are different commission fees for cash out for natural and legal persons.

Natural Persons
Default commission fee - 0.3% from cash out amount.

1000.00 EUR per week (from monday to sunday) is free of charge.

If total cash out amount is exceeded - commission is calculated only from exceeded amount (that is, for 1000.00 EUR there is still no commission fee).

This discount is applied only for first 3 cash out operations per week for each user - for forth and other operations commission is calculated by default rules (0.3%) - 
rule about 1000 EUR is applied only for first three cash out operations.

Legal persons
Commission fee - 0.3% from amount, but not less than 0.50 EUR for operation.

Currency for Commission Fee
Commission fee is always calculated in the currency of particular operation (for example, if you cash out USD, commission fee is also in USD).

Rounding
After calculating commission fee, it's rounded to the smallest currency item (for example, for EUR currency - cents) to upper bound (ceiled). For example, 0.023 EUR should be rounded to 3 Euro cents.
Rounding is performed after currency conversion.

Supported currencies
3 currencies are supported: EUR, USD and JPY.

When converting currencies, following conversion rates are applied: EUR:USD - 1:1.1497, EUR:JPY - 1:129.53

Input data
Input data is given in CSV file. Performed operations are given in that file. In each line following data is provided:

operation date in format Y-m-d
user's identificator, number
user's type, one of natural or legal
operation type, one of cash_in or cash_out
operation amount (for example 2.12 or 3)
operation currency, one of EUR, USD, JPY
All operations are ordered by their date ascendingly.

Expected Result
As a single argument program must accept a path to the input file.

Program must output result to stdout.

Result - calculated commission fees for each operation. In each line only final calculated commission fee must be provided without currency.

Example Data
➜  cat input.csv 
2014-12-31,4,natural,cash_out,1200.00,EUR
2015-01-01,4,natural,cash_out,1000.00,EUR
2016-01-05,4,natural,cash_out,1000.00,EUR
2016-01-05,1,natural,cash_in,200.00,EUR
2016-01-06,2,legal,cash_out,300.00,EUR
2016-01-06,1,natural,cash_out,30000,JPY
2016-01-07,1,natural,cash_out,1000.00,EUR
2016-01-07,1,natural,cash_out,100.00,USD
2016-01-10,1,natural,cash_out,100.00,EUR
2016-01-10,2,legal,cash_in,1000000.00,EUR
2016-01-10,3,natural,cash_out,1000.00,EUR
2016-02-15,1,natural,cash_out,300.00,EUR
2016-02-19,5,natural,cash_out,3000000,JPY
➜  php script.php input.csv
0.60
3.00
0.00
0.06
0.90
0
0.70
0.30
0.30
5.00
0.00
0.00
8612
Evaluation Criteria
all requirements must be met;
code quality - it's maintainability, extensibility, testability; speed of the system can also be considered, but is not as important as other criteria.
Task Submission
You can put the code publicly (in github or similar code control systems) if you want, but please note the requirement about Paysera name usage.

Send it in your favourite format (link to versioned code, code in zip file etc.) to one of the following emails based on your city, unless instructed otherwise:

code-vilnius@paysera.com
code-kaunas@paysera.com
code-sofia@paysera.com
code-manila@paysera.com
code-dhaka@paysera.com
code-saint-petersburg@paysera.com
code-plovdiv@paysera.com