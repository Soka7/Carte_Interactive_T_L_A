<!-- A DETRUIRE QUAND NETTOYAGE -->

defmodule ElixirExtractor do
  @moduledoc """
  Module pour simuler un extracteur d'élixir de Clash Royale.
  """

  # Élixir produit par niveau par tick
  @elixir_per_tick %{
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4
  }

  # Retourne le taux d'élixir pour un niveau donné
  defp elixir_rate(level) do
    Map.get(@elixir_per_tick, level, 0)
  end

  # Génère une liste de lignes ("Tick X : +Y élixir")
  def generate_lines(level, ticks) do
    rate = elixir_rate(level)

    1..ticks
    |> Enum.map(fn tick ->
      "Tick #{tick} : +#{rate} élixir"
    end)
  end

  # Affiche directement les lignes dans la console
  def print_lines(level, ticks) do
    rate = elixir_rate(level)

    for tick <- 1..ticks do
      IO.puts("Tick #{tick} : +#{rate} élixir")
    end
  end

  # Génère les lignes avec un cumul total
  def generate_with_total(level, ticks) do
    rate = elixir_rate(level)

    Enum.scan(1..ticks, 0, fn tick, total ->
      new_total = total + rate
      IO.puts("Tick #{tick} : total = #{new_total}")
      new_total
    end)
  end

  # Extraction simple (renvoie un map)
  def extract(level, minutes) do
    rate = elixir_rate(level)
    produced = rate * minutes

    %{
      level: level,
      minutes: minutes,
      elixir_produced: produced
    }
  end
end

# Exemple d'utilisation
# ElixirExtractor.print_lines(3, 5)
# ElixirExtractor.generate_with_total(4, 10)
# ElixirExtractor.extract(2, 5)
# ElixirExtractor.generate_lines(3, 5)