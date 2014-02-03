$(document).ready(function()
{

	setSubCategories();
	setTypes();
	// alert("Hello");

	//on category change, changes available sub-categories
	$("#category").change(function(evt){		
		evt.preventDefault();
		setSubCategories();
	});

	//on type change, changes available fields
	$("#type").change(function(evt){		
		evt.preventDefault();
		setTypes();
	});
	
});


function setSubCategories()
{
	if($("#category option:selected").text() == "Geek")
	{
		$("#subCatPanel").show();
		$("#subcategory").html("<option value='Computer Science'>Computer Science</option><option value='Science'>Science</option>");

	}
	else if($("#category option:selected").text() == "Holiday")
	{
		event.preventDefault();
		$("#subCatPanel").show();
		$("#subcategory").html("<option value='Halloween'>Halloween</option><option value='Thanksgiving'>Thanksgiving</option>");
	}
	else
	{
		event.preventDefault();
		$("#subCatPanel").hide();
	}	
}


function setTypes()
{

	if($("#type option:selected").text() == "Question & Answer")
	{
		$("#qandaPanel").show();
		$("#monologuePanel").hide();
		$("#urlPanel").hide();

	}
	else if($("#type option:selected").text() == "Monologue")
	{
		$("#qandaPanel").hide();
		$("#monologuePanel").show();
		$("#urlPanel").hide();

	}
	else if($("#type option:selected").text() == "Image")
	{
		$("#qandaPanel").hide();
		$("#monologuePanel").hide();
		$("#urlPanel").show();
	}	

}