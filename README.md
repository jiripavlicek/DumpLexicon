DumpLexicon
===========

dump MODX Revolution 2.x lexicon content from database do files

This script dumps any MODX Revolution 2.x lexicon content from 
database to include files.

This script runs outside of MODx, but uses its config and xPDO
objects.

How ho use
==========
1. Place script in some directory in your project (for example "./_dev").
2. Update MODX_CORE_PATH definition to fit path to your project core directory.
3. Update NAMESPACE_ definition in DumpLexicon.php file.
4. Optionaly change ORDERBY definition in the same file - if you want to
   sort exported lexicon items.
5. Optionaly change PATH definition. It defines directory in which are 
   created PHP files.
6. Run this script from within web browser.

Jiri Pavlicek