<? $file = $_GET['file']; ?>

<h1>Digitised page from accessions register <?echo $file ?></h1>
<object data="<? echo $_SERVER['PHP_SELF'] ?>?func=accessions_pdfs&amp;file=<?echo $file ?>" type="application/pdf" width="900" height="800" border="1"></object> 