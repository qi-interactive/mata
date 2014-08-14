MATA
====

MATA - generic framework for project-driven web applications


MATA installation
================= 

This section describes how to install Mata in your existing Yii Project: 

- clone MATA to the root of your project by issuing the command

```
git clone --recursive https://github.com/qi-interactive/mata.git
```

- execute in Terminal:

```
cd mata && php yiic mata install
```

- Follow the steps in the installation


- make sure Yii creates a mata application by adding the following to the top of index.php: 

```
$mata = dirname(__FILE__) . "/mata/components/MataWebApplication.php";
```

and replacing the last line with: 

```
require_once($mata);
Yii::createApplication("MataWebApplication", $config)->run();
```

-- You're done!

Mata
========

Mata Framework for Yii

## Changelog (major improvements only)

7 August 2014
- improvements to the side menu bar and main layout 
- added velocity.js

5 July 2014
- normalised all names, made everything M-prefixed 
- removed redundant files 
- moved certain files to relevant modules 