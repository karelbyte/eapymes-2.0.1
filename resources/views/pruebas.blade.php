@extends('layout')
@section('content')
  <div ng-controller="pruebas_clr">
      <img ng-src="../../storage/<%imgrute%>" ng-click="setimg()" class="img-rounded mouse" height="100" width="100">
      <input type="file" name="file" style="display: none;" uploader-model="file" id="imgperson">
      <hr>
      <%imgrute%>
      <hr>
    <!--  <form name="upload" ng-submit="uploadFile()">
          <input type="text" ng-model="name" /><br>
          <input type="file" name="file" uploader-model="file" /> <br>
          <input type="submit" value="Enviar">
      </form> -->
  </div>
@endsection
@section('scripts')
    <script src="app/pruebas.js"></script>
@endsection