import axios from "axios";
import React, { useEffect, useState } from "react";
import {
  Button,
  Input,
  Label,
  MainContainer,
  OptionContainer,
  OptionsContainer,
  RadioInput,
  Select,
} from "./App.styles";
import logo from "./logo.svg";

const string_filters = ["contains", "start_with", "end_with", "equals"];
const number_filters = ["equals", "gte", "lte"];

function App() {
  const [selected, setSelected] = useState<string>("name");
  const [error, setError] = useState<string>("");
  const [filterOption, setFilterOption] = useState("");
  const [filterValue, setFilterValue] = useState("");
  const [data, setData] = useState("");
  useEffect(() => {
    setFilterValue("");
  }, [filterOption]);
  const API = "http://127.0.0.1:8000/";

  const handleSubmitButton = async () => {
    console.log({ selected });
    try {
      const data = await axios.post(
        `${API}get_images`,
        {
          filter: {
            [selected]: {
              [filterOption]: filterValue,
            },
          },
        },
        {}
      );

      setData(data.data);
      setError("");
    } catch (error: any) {
      setError(error);
      setData("");
    }
  };

  return (
    <MainContainer>
      {error && <>Error {error.message}</>}
      <h1>Welcome </h1>
      <h2>Please choose</h2>
      <OptionsContainer>
        <OptionsContainer>
          <OptionContainer>
            <RadioInput
              onChange={() => setSelected("name")}
              defaultChecked
              name="select"
              id="name"
              type="radio"
              value="name"
            />
            <Label htmlFor="html">name</Label>
            <Select
              disabled={selected !== "name"}
              onChange={(e) => {
                setFilterOption(e.target.value);
              }}
              placeholder="Choose filtering option..."
            >
              {string_filters.map((item, key) => (
                <option key={key} value={item} label={item} />
              ))}
            </Select>
            <Input
              value={filterValue}
              onChange={(e) => setFilterValue(e.target.value)}
              disabled={selected !== "name"}
              placeholder="Filter value"
            />
          </OptionContainer>
          <OptionContainer>
            <RadioInput
              onChange={() => setSelected("pvp")}
              name="select"
              id="pvp"
              type="radio"
              value="pvp"
            />
            <Label htmlFor="html">pvp</Label>
            <Select
              disabled={selected === "name"}
              onChange={(e) => {
                setFilterOption(e.target.value);
              }}
              placeholder="Choose filtering option..."
            >
              {number_filters.map((item, key) => (
                <option key={key} value={item} label={item} />
              ))}
            </Select>
            <Input
              value={filterValue}
              onChange={(e) => setFilterValue(e.target.value)}
              disabled={selected === "name"}
              placeholder="Filter value"
            />
          </OptionContainer>
        </OptionsContainer>
        <Button onClick={handleSubmitButton}>Submit request</Button>
      </OptionsContainer>
      {JSON.stringify(data)};
    </MainContainer>
  );
}

export default App;
