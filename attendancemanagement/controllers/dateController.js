class DateController{
    S_MMDDYYYY(date){
        var newDate=new Date(date);
        return (Number(newDate.getMonth())+1)+"/"+newDate.getDate()+"/"+newDate.getFullYear();
    }
}
module .exports=new DateController();