defmodule ElixirExtractor do
  @elixir_per_minute %{
    1 => 1,
    2 => 2,
    3 => 3,
    4 => 4
  }

  def extract(level, minutes) do
    rate = Map.get(@elixir_per_minute, level, 0)
    produced = rate * minutes

    %{
      level: level,
      minutes: minutes,
      elixir_produced: produced
    }
  end
end
