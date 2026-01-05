defmodule ElixirGolem do
  @moduledoc """
  Module pour simuler un Golem d'élixir de Clash Royale.
  """

  # Points de vie par niveau
  @hp_per_level %{
    1 => 1000,
    2 => 1200,
    3 => 1400,
    4 => 1600
  }

  # Dégâts par tick par niveau
  @damage_per_level %{
    1 => 50,
    2 => 70,
    3 => 90,
    4 => 110
  }

  # Élexir récupéré à la destruction
  @elixir_on_death 3

  # Crée un golem avec un niveau et des points de vie initiaux
  def create_golem(level) do
    hp = Map.get(@hp_per_level, level, 1000)
    damage = Map.get(@damage_per_level, level, 50)

    %{
      level: level,
      hp: hp,
      damage: damage,
      elixir_collected: 0
    }
  end

  # Fait subir des dégâts au golem
  def take_damage(golem, dmg) do
    new_hp = max(golem.hp - dmg, 0)

    updated_golem =
      %{golem | hp: new_hp}

    if new_hp == 0 do
      IO.puts("Golem détruit ! +#{@elixir_on_death} élixir récupéré")
      %{updated_golem | elixir_collected: @elixir_on_death}
    else
      updated_golem
    end
  end

  # Golem attaque : affiche les dégâts infligés
  def attack(golem, tick) do
    IO.puts("Tick #{tick} : Golem inflige #{golem.damage} dégâts")
  end

  # Simule plusieurs ticks
  def simulate_battle(level, ticks, damage_per_tick) do
    golem = create_golem(level)

    Enum.reduce(1..ticks, golem, fn tick, g ->
      if g.hp > 0 do
        attack(g, tick)
        take_damage(g, damage_per_tick)
      else
        g
      end
    end)
  end

  # Génère des lignes d'état du golem
  def generate_status_lines(level, ticks, damage_per_tick) do
    golem = create_golem(level)

    1..ticks
    |> Enum.map_reduce(golem, fn tick, g ->
      g =
        if g.hp > 0 do
          attack(g, tick)
          take_damage(g, damage_per_tick)
        else
          g
        end

      line = "Tick #{tick} : HP = #{g.hp}, Elixir récupéré = #{g.elixir_collected}"
      {line, g}
    end)
    |> elem(0)
  end
end

# Exemple d'utilisation :
# ElixirGolem.simulate_battle(3, 5, 200)
# ElixirGolem.generate_status_lines(2, 8, 150)