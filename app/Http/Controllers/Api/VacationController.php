<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Vacation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VacationController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    return response()->json([
      'vacations' => Vacation::all(),
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param Request $request
   * @return
   * @throws \Exception
   */
  public function store(Request $request) {
    $user = $request->user();
    $start = Carbon::parse($request->start);
    $end = Carbon::parse($request->end);

    /**
     * Дата завершения отпуска не может быть меньше или равна дате начала отпуска
     */
    $is_not_valid_dates = !$end->gt($start);

    /**
     * Нельзя запросить отпуск по одни и теми же датами
     */
    $is_not_isset_vacation = Vacation::where('user_id', $user->id)
      ->where('start', $start->format('Y-m-d'))
      ->orWhere('end', $end->format('Y-m-d'))
      ->count();

    if ($is_not_valid_dates || $is_not_isset_vacation) {
      throw new \Exception ('Invalidate dates');
    }

    $vacation = new Vacation([
      'user_id' => $user->id,
      'start' => $request->start,
      'end' => $request->end,
      'readonly' => $request->readonly,
    ]);

    $vacation->save();

    return response()->json([
      'vacation' => $vacation,
    ]);
  }

  /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id) {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param Request $request
   * @param Vacation $vacation
   * @return void
   */
  public function update(Request $request, Vacation $vacation) {

    /**
     * Если отпуск зафиксирован
     */
    if ($vacation->readonly) {
      return response()->json([
        'updated' => false,
      ]);
    }

    $user = $request->user();
    $start = Carbon::parse($request->start);
    $end = Carbon::parse($request->end);

    $isset_dates = Vacation::where('user_id', $user->id)
      ->where('start', $start->format('Y-m-d'))
      ->orWhere('end', $end->format('Y-m-d'))
      ->count();

    if ($isset_dates) {
      throw new \Exception ('Invalidate dates');
    }

    return response()->json([
      'updated' => $vacation->update($request->all()),
    ]);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    //
  }

  public function fixed(Request $request, Vacation $vacation) {
    if ($request->user()->hasRole('leader', 'admin')) {
      $vacation->readonly = true;

      $vacation->save();
    }
  }
}
