Govspeak a markup language derived from [Markdown](http://daringfireball.net/projects/markdown/syntax "Markdown syntax"), developed by the [Government Digital Service](http://digital.cabinetoffice.gov.uk) for use on [GOV.UK](https://www.gov.uk). As well as implementing Markdown, it contains additional elements that are useful for publishing official information. [govspeak-drupal](https://github.com/LambethCouncil/govspeak-drupal) implements [Govspeak](https://github.com/alphagov/govspeak) for [Drupal](http://drupal.org/). The implementation of Markdown is [John Gruber's php Markdown](http://michelf.ca/projects/php-markdown/).

# Installation 

- Clone this repository, or download the [zipped version](https://github.com/LambethCouncil/govspeak-drupal/archive/master.zip) and unzip it. 
- Place the govspeak-drupal directory in sites/all/modules directory of your Drupal installation.  
The folder should be renamed from 'govspeak-drupal' to 'govspeak'  
At Lambeth, we have put it in sites/all/modules/custom, so in our case, govspeak.module is here: sites/all/modules/custom/govspeak/govspeak.module
- Enable the module in the admin section of your Drupal install.

**Note:** _This module was written by taking the [markdown module for Drupal](http://drupal.org/project/markdown) and extending it. As a result, for now anyway, you can't use the markdown module alongside this govspeak module._

**Note:** _The module comes with very basic css styles for demonstration purposes. You will almost certainly want to overwrite them._

# Usage

- In your Drupal front-end, go to admin/config/content/formats/add
- Add a text format (you can name it Govspeak or whatever you like)
- Under Enabled filters, check 'Govspeak'

- Add a new piece of content (for example an article: node/add/article)

- Enter the following text:

```
@test advisory@

^test informational [test](http://bbc.co.uk)^

^test informational <a href="http://bbc.co.uk">test</a>^

^this is a warning box^

%this is helpful%

$E
**Example:** this is an example
$E

{::highlight-answer}
The VAT rate is *20%*
{:/highlight-answer}

fds

$C
**Student Finance England**
**Telephone:** 0845 300 50 90
**Minicom:** 0845 604 44 34
$C

$A
Hercules House
Hercules Road
London SE1 7DU
$A

$D
[An example form download link](http://example.com/ "Example form")

Something about this form download
$D

s1. numbers
s2. to the start
s3. of your list


s1. second list 1
s2. second list 2
s3. second list 3

x[this is an external link](http://bbc.co.uk)x

$CTA
A call to action
$CTA

$P
A palce
$P

$I
An information
$I

$AI
Aditional information
$AI

Special rules apply if you're exporting a vehicle outside the EU.

*[EU]:European Union
```

- For Text format, choose Govspeak.

- Click Save.

# How to write Govspeak

For standard things like headings, tables and links, follow the [standard Markdown syntax](http://daringfireball.net/projects/markdown/syntax "Markdown syntax"). Below is a list of the additional extensions that Govspeak provides.


## Callouts

### Information callouts

    ^This is an information callout^

creates a callout with an info (i) icon.

    <div class="application-notice info-notice">
      <p>This is an information callout</p>
    </div>
    
which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/information.png"/>

### Warning callouts

    %This is a warning callout%

creates a callout with a warning or alert (!) icon

    <div class="application-notice help-notice">
        <p>This is a warning callout</p>
    </div>

which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/warning.png"/>


### Example callout

    $E
    **Example**: Open the pod bay doors
    $E

creates an example box

    <div class="example">
    <p><strong>Example:</strong> Open the pod bay doors</p>
    </div>

which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/example.png"/>

## Highlights

### Advisory

    @This is a very important message or warning in the form of a heading@

highlights the enclosed

    <h3 class="advisory">
        <span>This section is a very important</span>
    </h3>

which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/advisory.png"/>


### Answer

    {::highlight-answer}
    The VAT rate is *20%*
    {:/highlight-answer}

creates a  highlight box with optional preamble text and giant text denoted with `**`

    <div class="highlight-answer">
    <p>The standard VAT rate is <em>20%</em></p>
    </div>

which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/answer.png"/>


## Points of Contact

### Contact

    $C
    **Student Finance England**
    **Telephone:** 0845 300 50 90
    **Minicom:** 0845 604 44 34
    $C


creates an contact box

    <div class="contact">
    <p><strong>Student Finance England</strong><br><strong>Telephone:</strong> 0845 300 50 90<br><strong>Minicom:</strong> 0845 604 44 34</p>
    </div>

which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/contact.png"/>

### Address

    $A
    Hercules House
    Hercules Road
    London SE1 7DU
    $A

creates an address box

    <div class="address"><div class="adr org fn"><p>
    Hercules House
    <br>Hercules Road
    <br>London SE1 7DU
    <br></p></div></div>
    
which looks like this

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/address.png"/>

## Downloads

    $D
    [An example form download link](http://example.com/ "Example form")

    Something about this form download
    $D

creates a file download box

    <div class="form-download">
    <p><a href="http://example.com/" title="Example form" rel="external">An example form download link.</a></p>
    </div>

which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/download.png"/>

## Steps

Steps can be created similar to an ordered list:

    s1. numbers
    s2. to the start
    s3. of your list

which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/steps.png"/>

Note that steps need an extra line break after the final step (ie. two full blank lines) or other markdown directly afterwards won't work. If you have a subhead after - add a line break after this.

## Abbreviations

Abbreviations can be defined at the end of the document, and any occurrences elswhere in the document will wrapped in an `<abbr>` tag. They are parsed in the order in which they are defined, so `PCSOs` should be defined before `PCSO`, for example.

    Special rules apply if you’re exporting a vehicle outside the EU.

    *[EU]:European Union

becomes

    <p>Special rules apply if you’re exporting a vehicle outside the <abbr title="European Union">EU</abbr>.</p>
    
## External links

x\[London Mural Preservation Society]\(http://londonmuralpreservationsociety.com/)x

creates a link with an external-link class, and rel=external
    
    <a class="external-link" rel="external" href="http://londonmuralpreservationsociety.com">London Mural Preservation Society</a>

which looks like

<img src="https://raw.github.com/LambethCouncil/govspeak-drupal/master/example_images/external_link.png"/>
