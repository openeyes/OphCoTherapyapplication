OphCoTherapyApplication Module
==============================

This module is in active development and is targetted for 1.4 release.

It's pre-alpha, and not recommended for use or analysis by any but the significantly masochistic.

Dependencies
============

1. Requires OphTrIntravitrealinjection

Elements
========

The Element_OphCoTherapyapplication_Email class is an element that is created by the processing of the application. As such it is not an element that should be directly edited.

Templates
=========

When an application is processed, an email is generated for each eye. the templates for the content of this email exist in

views/email/
	|
	\------- email_compliant.php  - email text for NICE Compliant therapy applications
	\------- email_noncomplaint.php - email text for non-NICE Compliant therapy applications
	\------- pdf_compliant.php - pdf template for compliant applications
	\------- pdf_compliant_[template_code].php - pdf template for compliant applications
	\------- pdf_noncompliant.php - pdf template for non compliant applications
	\------- pdf_noncompliant_[template_code].php - pdf template for non compliant applications

If a specific drug needs a different attachment, then it should be assigned a template code in the admin for treatments. The appropiately named template can then be included in the email directory.

TODO: implement the same for email text (template override)
TODO: setup gitignore appropriately to ignore custom templates that are put here.