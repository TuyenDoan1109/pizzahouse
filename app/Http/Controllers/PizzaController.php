<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pizza;

use Illuminate\Support\Facades\Validator; 

class PizzaController extends Controller
{

  public function index() {

    $pizzas = Pizza::latest()->get();      

    return view('pizzas.index', [
      'pizzas' => $pizzas,
    ]);
  }

  public function show($id) {
    
    $pizza = Pizza::findOrFail($id);

    return view('pizzas.show', ['pizza' => $pizza]);
  }

  public function create() {
    return view('pizzas.create');
  }

  public function store(Request $request) {
    // $request->validate([
    //   'name' => 'required|min:3',
    //   'toppings' => 'required'
    // ]); 

    $validator = Validator::make($request->all(), [
      'name' => 'required|min:2',
      'toppings' => 'required'
    ]);

    if ($validator->fails()) {
      return back()->with('toast_error', $validator->messages()->all()[0])->withInput();
    }

    $pizza = new Pizza();
    $pizza->name = request('name');
    $pizza->type = request('type');
    $pizza->base = request('base');
    $pizza->toppings = request('toppings');

    $pizza->save();

    return redirect('/')->with('toast_success', 'Thanks for your order!');

  }

  public function destroy($id) {

    $pizza = Pizza::findOrFail($id);
    $pizza->delete();

    return redirect('/pizzas')->with('toast_success', 'Order Completed Successfully!');;

  }

}
