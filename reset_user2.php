$user = App\Models\User::where('name', 'like', '%Chero Sandoval%')->first();
if ($user) {
    echo "User found: " . $user->name . " (ID: " . $user->id . ")\n";
    $user->reservas()->delete();
    try {
        $user->update(['sanciones' => 0, 'is_sancionado' => false, 'motivo_sancion' => null]);
    } catch (\Exception $e) {
        $user->update(['is_sancionado' => false, 'motivo_sancion' => null]);
    }
    // Also reset password to default
    $user->password = Hash::make('12345678');
    $user->save();
    echo "Reservations deleted, penalties removed, and password reset to '12345678'.\n";
} else {
    echo "User not found.\n";
}
