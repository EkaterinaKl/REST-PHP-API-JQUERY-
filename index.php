       <!DOCTYPE html>
       <html>
       <head>
       	<title>Тестовое задание</title>
       	
         <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
         <meta charset="UTF-8">
         <link href="css/styles.css" rel="stylesheet">
         <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
         <script src="js/bootstrap.min.js"></script>

         <script src="js/app.js"></script>

     </head>
     <body>


       <div class="wrapper container">
        <div class="transparency">
         <!-- Это прозрачный блок-->

       </div>
       <header>




         <div class="heading">
          <h1>Тестовые задания</h1>
        </div>

      </header>
      <div class="row">

        <section class="col-md-17">




         <div class="panel panel-primary">
          <div class="panel-heading">
           <h4 class="panel-title">1. Выдача всех организаций находящихся в конкретном здании</h4>
         </div>

         <div class="panel-body">
           <form role="form" id="form1">
            <div class="form-group">
             <label for="exampleInputEmail1">Введите адрес</label>
             <input type="text" class="form-control" required="required" id="adress" placeholder="Адрес">
           </div>
           <div class="form-group">

             <div class="row">



              <div class="btn-group col-xs-20">
               <label >
                <input type="radio" name="id_type" value="1" autocomplete="off" checked>Точное соответствие
              </label>
              <label >
                <input type="radio" name="id_type" value="2" autocomplete="off"> Гибкий поиск (удаляет несколько пробелов, заменяет \ на /, часть улицы)
              </label>

            </div>

          </div>
 Доступные значения в базе:  Дачная, 8/2; Дальневосточная, 6; Даурская, 8Б; Дальневосточная, 10
        </div>
        <button type="submit" class="btn btn-default">Отправить</button>
      </form>

    </div>
  </div>

  <div class="panel panel-primary">
    <div class="panel-heading">
     <h4 class="panel-title">2. Список всех организаций, которые относятся к указанной рубрике</h4>
   </div>

   <div class="panel-body">
     <form role="form" action="api.php" id="form2">
      <div class="form-group">
       <label for="id_ca">Введите рубрику (номер)</label>
       <input type="text" class="form-control" required="required" id="id_ca" placeholder="Номер рубрики">
	    Доступные значения в базе:  1-10; 1 - несколько записей
     </div>

     <button type="submit" class="btn btn-default">Отправить</button>
   </form>
 </div>
</div>

<div class="panel panel-primary">
  <div class="panel-heading">
   <h4 class="panel-title">3. Список организаций, которые находятся в заданном радиусе/прямоугольной области относительно указанной точки на карте.
   </h4>
 </div>

 <div class="panel-body">
   <form role="form" action="api.php" id="form3">
    <div class="form-group">
     <label for="num_x">Х:</label>
     <input type="text" class="form-control" id="num_x" required="required" placeholder="Координата Х">
   </div>

   <div class="form-group">
     <label for="num_y">У:</label>
     <input type="text" class="form-control" id="num_y" required="required" placeholder="Координата У">
   </div>


   <div class="form-group">

             <div class="row">



              <div class="btn-group col-xs-24">
               <label >
                <input type="radio" name="id_type" value="1" autocomplete="off" checked>Радиус круга
              </label>
              <label >
                <input type="radio" name="id_type" value="2" autocomplete="off"> "Радиус" квадрата
              </label>
 <label >
                <input type="radio" name="id_type" value="3" autocomplete="off"> Кординаты верхнего правого прямоугольника
              </label>
            </div>

          </div>

        </div>
<div class="form-group ">

             <div class="row">



              <div class="col-xs-4">
                 <label for="num_R">R:</label> <input type="text" class="form-control" id="num_R" placeholder="Радиус">
             </div> 
<div class="col-xs-4">
            
             </div> 
             <div class="col-xs-8 row"> <label for="num_x1">X1:</label>
  <input type="text" class="form-control" id="num_x1" placeholder="Координата X1">
</div>
<div class="col-xs-8 row">
  <label for="num_y1">У1:</label>
  <input type="text" class="form-control" id="num_y1" placeholder="Координата У1">
</div>


            </div>
Доступные значения в базе (x,y):  
(5,10),( 3, 5), (2, 22), (22, 2), (1, 5),( 7, 6 ), ( 7, 77),( 4, 5) 
          </div>

  



<button type="submit" class="btn btn-default">Отправить</button>
</form>
</div>
</div>

<div class="panel panel-primary">
 <div class="panel-heading">
   <h4 class="panel-title">4. Список зданий
   </h4>
 </div>

 <div class="panel-body">
   <form role="form" action="api.php" id="form4">


     <button type="submit" class="btn btn-default">Получить</button>
   </form>
 </div>
</div>

<div class="panel panel-primary">
 <div class="panel-heading">
   <h4 class="panel-title">
     5. Выдача информации об организациях по их идентификаторам
   </h4>
 </div>

 <div class="panel-body">
   <form role="form" action="api.php" id="form5">
     <div class="form-group">
       <label for="id_c">Идентификатор</label>
       <input type="text" class="form-control" required="required" id="id_c" placeholder="ID">
     
Доступные значения в базе:  1-7; 7 - несколько категорий; несколько телефонов</div>
     <button type="submit" class="btn btn-default">Отправить</button>
   </form>
 </div>
</div>

<div class="panel panel-primary">
 <div class="panel-heading">
   <h4 class="panel-title">
     6. Дерево рубрик каталога со всеми предками, с возможностью фильтрации по потомкам конкретного узла
   </h4>
 </div>

 <div class="panel-body">
 
 <form role="form" action="api.php" id="form6">
     <div class="form-group">
       <label for="id_ca">Введите рубрику (номер)</label>
       <input type="text" class="form-control" id="id_ca" placeholder="Номер рубрики">
     Если номер не указан - выводит все дерево;<br>
 если номер указан - выводит ветку (например, для номера 2 или 3).<br>
 Доступные значения в базе:  1-9</div>

     <button type="submit"  class="btn btn-default">Получить дерево</button>
   </form>
 </div>
</div>

<div class="panel panel-primary">
 <div class="panel-heading">
   <h4 class="panel-title">7. Поиск организации по названию
   </h4>
 </div>

 <div class="panel-body">
   <form role="form" action="api.php" id="form7">
     <div class="form-group">
       <label for="name">Название</label>
       <input type="text" class="form-control" required="required" id="name" placeholder="Название">
	    Поиск выполняется по неточному соответствию <br>
		Доступные значения в базе:  ООО "Рога и копыта", ООО ДизельТехКомплект
		
     </div>



     <div class="form-group">
       <button type="submit" class="btn btn-default">Отправить</button>
     </div>
   </form>
 </div>
</div>

</section>
</div>
</div>
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-7">
        <h3>Контактная информация:</h3>
        <p>

          <p>E-mail:bedew@yandex.ru</p>

        </p>
      </div>
    </div>



  </div>
</footer>
<div id="modalBox" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Заголовок модального окна -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Результат запроса</h4>
      </div>
      <!-- Основное содержимое модального окна -->
      <div class="modal-body">
        <div id="result">

        </div>

      </div>
    </div>
  </div>

</body>
</html>